<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskApiController extends Controller
{
    /**
     * Inject TaskService.
     */
    public function __construct(
        protected TaskService $taskService
    ) {}

    /**
     * Display a listing of tasks.
     */
    public function index(Request $request)
    {
        $tasks = $this->taskService->getPaginatedTasksForUser(
            $request->user(),
            $request->search,
            $request->filter
        );

        $tasks->load('categories');

        return TaskResource::collection($tasks);
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        Gate::authorize('view', $task);

        $task->load('categories');

        return new TaskResource($task);
    }

    /**
     * Store a newly created task.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        
        if ($request->user()->hasRole('admin') || $request->user()->can('edit any task')) {
            $targetUser = User::findOrFail($data['user_id']);
        } else {
            $targetUser = $request->user();
        }

        $task = $this->taskService->createTask($targetUser, $data);
        $task->load('categories');

        return new TaskResource($task);
    }

    /**
     * Update the specified task.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        if ($request->user()->hasRole('admin') || $request->user()->can('edit any task')) {
            if (isset($data['user_id'])) {
                $task->user_id = $data['user_id'];
            }
        }

        $this->taskService->updateTask($task, $data);
        $task->load('categories');

        return new TaskResource($task);
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $this->taskService->deleteTask($task);

        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }
}
