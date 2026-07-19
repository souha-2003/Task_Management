<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get all tasks of the currently authenticated user with search and filter support
        $query = auth()->user()->tasks()
            ->search($request->search);

        if ($request->filter === 'completed') {
            $query->completed();
        } elseif ($request->filter === 'pending') {
            $query->pending();
        }

        // Order tasks by latest and paginate (5 tasks per page)
        $tasks = $query->latest()->paginate(5)->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // Get already validated and sanitized data from StoreTaskRequest
        $validated = $request->validated();

        // Create the task associated with the current user
        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Verify that the task belongs to the current user
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // Verify that the task belongs to the current user
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // Note: Task ownership authorization is handled automatically in UpdateTaskRequest::authorize()

        // Get already validated and sanitized data from UpdateTaskRequest
        $validated = $request->validated();

        // Update the task details
        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Verify that the task belongs to the current user
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the task
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    /**
     * Toggle the completed status of the specified task.
     */
    public function toggle(Task $task)
    {
        // Verify that the task belongs to the current user
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Toggle the completed status
        $task->update([
            'completed' => !$task->completed
        ]);

        return redirect()->back()->with('success', 'Task status updated successfully!');
    }
}
