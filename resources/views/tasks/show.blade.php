<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="fw-bold mb-0 text-dark">📋 Task Details</h2>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-3 fw-semibold">
                    &larr; Back to List
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <!-- Task Title -->
                    <div class="mb-4">
                        <h4 class="text-secondary small text-uppercase fw-bold mb-1">Title</h4>
                        <h2 class="fw-bold text-dark">{{ $task->title }}</h2>
                    </div>

                    <!-- Task Status -->
                    <div class="mb-4">
                        <h4 class="text-secondary small text-uppercase fw-bold mb-1">Status</h4>
                        <div class="d-flex align-items-center gap-3">
                            @if ($task->completed)
                                <span class="badge bg-success px-3 py-2 fs-6 rounded-pill">Completed</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2 fs-6 rounded-pill">Pending</span>
                            @endif

                            <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-primary fw-semibold px-3">
                                    Mark as {{ $task->completed ? 'Pending' : 'Completed' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="mb-4">
                        <h4 class="text-secondary small text-uppercase fw-bold mb-1">Categories</h4>
                        <div>
                            @forelse ($task->categories as $category)
                                <span class="badge bg-{{ $category->color }} fs-6 px-3 py-2 rounded-pill me-1 mb-1">{{ $category->name }}</span>
                            @empty
                                <span class="text-muted font-italic">No categories assigned.</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h4 class="text-secondary small text-uppercase fw-bold mb-1">Description</h4>
                        <div class="p-3 bg-light rounded border text-dark" style="white-space: pre-line;">
                            {{ $task->description }}
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="mb-4">
                        <h4 class="text-secondary small text-uppercase fw-bold mb-1">Note</h4>
                        @if ($task->note)
                            <div class="p-3 bg-light rounded border border-warning-subtle text-dark" style="white-space: pre-line;">
                                {{ $task->note }}
                            </div>
                        @else
                            <p class="text-muted font-italic">No additional notes.</p>
                        @endif
                    </div>

                    <!-- Metadata (Dates) -->
                    <div class="row text-secondary small pt-3 border-top g-3">
                        <div class="col-md-6 col-12">
                            <strong>Created At:</strong> {{ $task->created_at->format('F j, Y - g:i A') }}
                        </div>
                        <div class="col-md-6 col-12">
                            <strong>Last Updated:</strong> {{ $task->updated_at->format('F j, Y - g:i A') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning text-dark px-4 fw-semibold shadow-sm">
                    ✏️ Edit Task
                </a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Are you sure you want to delete this task?')" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 fw-semibold shadow-sm">
                        🗑️ Delete Task
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
