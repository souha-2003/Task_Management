<x-app-layout>
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 col-12 mb-3 mb-md-0">
            <h2 class="fw-bold mb-0 text-dark">📋 My Tasks</h2>
        </div>
        <div class="col-md-6 col-12 text-md-end text-start">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary px-4 fw-semibold shadow-sm">
                ➕ Add New Task
            </a>
        </div>
    </div>

    <!-- Search Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tasks.index') }}" class="row g-3">
                <div class="col-md-8 col-12">
                    <input type="text" name="search" class="form-control" placeholder="Search tasks by title..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 col-6">
                    <button type="submit" class="btn btn-primary  w-100 fw-semibold">Search</button>
                </div>
                <div class="col-md-2 col-6">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary  w-100 fw-semibold">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tasks List Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if ($tasks->isEmpty())
                <div class="text-center py-5">
                    <h5 class="text-secondary mb-3">No tasks found.</h5>
                    @if (request('search'))
                        <p class="text-muted">No matches for: <strong>"{{ request('search') }}"</strong></p>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">Clear Search</a>
                    @else
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Your First Task</a>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="py-3 px-4">Title</th>
                                <th scope="col" class="py-3">Description</th>
                                <th scope="col" class="py-3">Note</th>
                                <th scope="col" class="py-3 text-center">Completed</th>
                                <th scope="col" class="py-3">Created At</th>
                                <th scope="col" class="py-3 text-center px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="px-4 fw-bold text-dark">{{ $task->title }}</td>
                                    <td class="text-muted" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $task->description }}
                                    </td>
                                    <td class="text-muted" style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $task->note ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if ($task->completed)
                                                <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm" title="Click to change status">
                                                    Yes
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-secondary btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm" title="Click to change status">
                                                    No
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>{{ $task->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="text-center px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-info btn-sm px-3 fw-semibold">
                                                View
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-warning btn-sm px-3 fw-semibold">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Are you sure you want to delete this task?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-semibold">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if ($tasks->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $tasks->links('pagination::bootstrap-5') }}
        </div>
    @endif

</x-app-layout>
