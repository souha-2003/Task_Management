<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Services\TaskService;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * حقن TaskService في الكنترولر
     */
    public function __construct(
        protected TaskService $taskService
    ) {}

    /**
     * عرض قائمة المهام.
     */
    public function index(Request $request)
    {
        $tasks = $this->taskService->getPaginatedTasksForUser(
            auth()->user(),
            $request->search,
            $request->filter
        );

        return view('tasks.index', compact('tasks'));
    }

    /**
     * عرض نموذج إنشاء مهمة جديدة.
     */
    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    /**
     * حفظ المهمة الجديدة في قاعدة البيانات.
     */
    public function store(StoreTaskRequest $request)
    {
        $this->taskService->createTask(auth()->user(), $request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * عرض تفاصيل المهمة.
     */
    public function show(Task $task)
    {
        Gate::authorize('view', $task);

        $task->load('categories');

        return view('tasks.show', compact('task'));
    }

    /**
     * عرض نموذج تعديل المهمة.
     */
    public function edit(Task $task)
    {
        Gate::authorize('update', $task);

        $categories = Category::all();

        return view('tasks.edit', compact('task', 'categories'));
    }

    /**
     * تحديث بيانات المهمة.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->taskService->updateTask($task, $request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * حذف المهمة.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $this->taskService->deleteTask($task);

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    /**
     * تبديل حالة التناوب للمهمة (مكتملة / غير مكتملة).
     */
    public function toggle(Task $task)
    {
        Gate::authorize('update', $task);

        $this->taskService->toggleTaskStatus($task);

        return redirect()->back()->with('success', 'Task status updated successfully!');
    }
}

