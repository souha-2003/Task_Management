<x-app-layout>
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 col-12 mb-3 mb-md-0">
            <h2 class="fw-bold mb-0 text-dark">📋 {{ __('messages.tasks') }}</h2>
        </div>
        <div class="col-md-6 col-12 text-md-end text-start">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary px-4 fw-semibold shadow-sm">
                ➕ {{ __('messages.create_task') }}
            </a>
        </div>
    </div>

    <!-- Search Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tasks.index') }}" class="row g-3">
                <div class="col-md-6 col-12">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('messages.search_placeholder') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-2 col-12">
                    <select name="filter" class="form-select" onchange="this.form.submit()">
                        <option value="" {{ request('filter') === '' ? 'selected' : '' }}>{{ __('messages.all_statuses') }}</option>
                        <option value="pending" {{ request('filter') === 'pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                        <option value="in_progress" {{ request('filter') === 'in_progress' ? 'selected' : '' }}>{{ __('messages.in_progress') }}</option>
                        <option value="review" {{ request('filter') === 'review' ? 'selected' : '' }}>{{ __('messages.review') }}</option>
                        <option value="completed" {{ request('filter') === 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">{{ __('messages.search') }}</button>
                </div>
                <div class="col-md-2 col-6">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary w-100 fw-semibold">{{ __('messages.reset') }}</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tasks List Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if ($tasks->isEmpty())
                <div class="text-center py-5">
                    <h5 class="text-secondary mb-3">{{ __('messages.no_tasks_found') }}</h5>
                    @if (request('search'))
                        <p class="text-muted">{{ __('messages.no_matches') }} <strong>"{{ request('search') }}"</strong></p>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">{{ __('messages.clear_search') }}</a>
                    @else
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">{{ __('messages.create_first_task') }}</a>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="py-3 px-4">{{ __('messages.task_title') }}</th>
                                <th scope="col" class="py-3 d-none d-md-table-cell">{{ __('messages.task_description') }}</th>
                                <th scope="col" class="py-3 d-none d-md-table-cell">{{ __('messages.task_note') }}</th>
                                <th scope="col" class="py-3 text-center">{{ __('messages.status') }}</th>
                                <th scope="col" class="py-3 d-none d-md-table-cell">{{ __('messages.created_at') }}</th>
                                <th scope="col" class="py-3 text-center px-4">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="px-4 fw-bold text-dark">
                                        <div>{{ $task->title }}</div>
                                        @if(auth()->user()->can('edit any task') || auth()->user()->can('delete any task'))
                                            <div class="small text-secondary mt-1 fw-semibold" style="font-size: 0.75rem;">
                                                👤 {{ __('messages.task_owner') }}: {{ $task->user->name ?? __('messages.unknown') }}
                                            </div>
                                        @endif
                                        <div class="mt-1 d-flex flex-wrap gap-1">
                                            @foreach ($task->categories as $category)
                                                <span class="badge font-monospace" style="font-size: 0.7rem; background-color: {{ $category->color }}1a; color: {{ $category->color }}; border: 1px solid {{ $category->color }}33;">{{ $category->name }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-muted d-none d-md-table-cell" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $task->description }}
                                    </td>
                                    <td class="text-muted d-none d-md-table-cell" style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $task->note ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                             @if ($task->status === 'completed')
                                                 <button type="submit" class="btn btn-status-completed btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm" title="{{ __('Click to change status') }}">
                                                     {{ __('messages.completed') }}
                                                 </button>
                                                 @if($task->completed_at)
                                                     <div class="mt-1 fw-medium" style="font-size: 0.72rem; color: #94a3b8; line-height: 1.2;">
                                                         {{ $task->completed_at->translatedFormat('d M H:i') }}
                                                     </div>
                                                 @endif
                                             @elseif ($task->status === 'review')
                                                 <button type="submit" class="btn btn-status-review btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm" title="{{ __('Click to change status') }}">
                                                     {{ __('messages.review') }}
                                                 </button>
                                             @elseif ($task->status === 'in_progress')
                                                 <button type="submit" class="btn btn-status-in_progress btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm" title="{{ __('Click to change status') }}">
                                                     {{ __('messages.in_progress') }}
                                                 </button>
                                             @else
                                                 <button type="submit" class="btn btn-status-pending btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm" title="{{ __('Click to change status') }}">
                                                     {{ __('messages.pending') }}
                                                 </button>
                                             @endif
                                        </form>
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $task->created_at->translatedFormat('d M Y H:i') }}</td>
                                    <td class="text-center px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-info btn-sm px-3 fw-semibold">
                                                {{ __('messages.view') }}
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-warning btn-sm px-3 fw-semibold">
                                                {{ __('messages.edit') }}
                                            </a>
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this task?') }}')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-semibold">
                                                    {{ __('messages.delete') }}
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
