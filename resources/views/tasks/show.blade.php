<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="fw-bold mb-0 text-dark">📋 {{ __('Task Details') }}</h2>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-3 fw-semibold">
                    &larr; {{ __('messages.back_to_list') }}
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <!-- Task Title -->
                    <div class="mb-4">
                        <h4 class="text-secondary small text-uppercase fw-bold mb-1">{{ __('messages.task_title') }}</h4>
                        <h2 class="fw-bold text-dark">{{ $task->title }}</h2>
                    </div>

                    <!-- Task Status -->
                    <div class="mb-4">
                        <h4 class="text-secondary small text-uppercase fw-bold mb-1">{{ __('messages.status') }}</h4>
                        <div class="d-flex align-items-center gap-3">
                            @if ($task->status === 'completed')
                                <div class="d-flex flex-column align-items-start">
                                    <span class="badge badge-status-completed px-3 py-2 fs-6 rounded-pill fw-bold">{{ __('messages.completed') }}</span>
                                    @if($task->completed_at)
                                        <div class="mt-1 fw-medium" style="font-size: 0.75rem; color: #94a3b8;">
                                            📅 {{ $task->completed_at->translatedFormat('d M Y H:i') }}
                                        </div>
                                    @endif
                                </div>
                            @elseif ($task->status === 'review')
                                <span class="badge badge-status-review px-3 py-2 fs-6 rounded-pill fw-bold">{{ __('messages.review') }}</span>
                            @elseif ($task->status === 'in_progress')
                                <span class="badge badge-status-in_progress px-3 py-2 fs-6 rounded-pill fw-bold">{{ __('messages.in_progress') }}</span>
                            @else
                                <span class="badge badge-status-pending px-3 py-2 fs-6 rounded-pill fw-bold">{{ __('messages.pending') }}</span>
                            @endif

                            <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-primary fw-semibold px-3">
                                    {{ __('Change Status') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="mb-4">
                        <h4 class="text-secondary small text-uppercase fw-bold mb-1">{{ __('messages.categories') }}</h4>
                        <div>
                            @forelse ($task->categories as $category)
                                <span class="badge fs-6 px-3 py-2 rounded-pill me-1 mb-1" style="background-color: {{ $category->color }}1a; color: {{ $category->color }}; border: 1px solid {{ $category->color }}33;">{{ $category->name }}</span>
                            @empty
                                <span class="text-muted font-italic">{{ __('No categories assigned.') }}</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h4 class="text-secondary small text-uppercase fw-bold mb-1">{{ __('messages.task_description') }}</h4>
                        <div class="p-3 bg-light rounded border text-dark" style="white-space: pre-line;">
                            {{ $task->description }}
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="mb-4">
                        <h4 class="text-secondary small text-uppercase fw-bold mb-1">{{ __('messages.note') }}</h4>
                        @if ($task->note)
                            <div class="p-3 bg-light rounded border border-warning-subtle text-dark" style="white-space: pre-line;">
                                {{ $task->note }}
                            </div>
                        @else
                            <p class="text-muted font-italic">{{ __('No additional notes.') }}</p>
                        @endif
                    </div>

                    <!-- Metadata (Dates) -->
                    <div class="row text-secondary small pt-3 border-top g-3">
                        <div class="col-md-6 col-12">
                            <strong>{{ __('messages.created_at') }}:</strong> {{ $task->created_at->translatedFormat('F j, Y - g:i A') }}
                        </div>
                        <div class="col-md-6 col-12">
                            <strong>{{ __('messages.last_updated') }}:</strong> {{ $task->updated_at->translatedFormat('F j, Y - g:i A') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning text-dark px-4 fw-semibold shadow-sm">
                    ✏️ {{ __('messages.edit') }}
                </a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this task?') }}')" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 fw-semibold shadow-sm">
                        🗑️ {{ __('messages.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
