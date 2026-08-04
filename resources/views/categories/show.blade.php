<x-app-layout>
    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">🏷️ {{ __('Category') }}: {{ $category->name }}</h2>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary px-3 fw-semibold text-nowrap">
                &larr; {{ __('messages.back_to_list') }}
            </a>
            @can('manage categories')
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning px-3 fw-semibold text-nowrap">
                {{ __('messages.edit') }}
            </a>
            @endcan
        </div>
    </div>

    <!-- Associated Tasks Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0 text-dark">📋 {{ __('Tasks in this Category') }}</h5>
        </div>
        <div class="card-body p-0">
            @if ($tasks->isEmpty())
                <div class="text-center py-5">
                    <h5 class="text-secondary mb-3">{{ __('No tasks found in this category.') }}</h5>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">{{ __('Create a Task') }}</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 px-4">{{ __('messages.task_title') }}</th>
                                <th scope="col" class="py-3 d-none d-md-table-cell">{{ __('messages.task_description') }}</th>
                                <th scope="col" class="py-3 text-center">{{ __('messages.status') }}</th>
                                <th scope="col" class="py-3 d-none d-md-table-cell">{{ __('messages.created_at') }}</th>
                                <th scope="col" class="py-3 text-center px-4">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="px-4 fw-bold text-dark">
                                        {{ $task->title }}
                                    </td>
                                    <td class="text-muted d-none d-md-table-cell" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $task->description }}
                                    </td>
                                    <td class="text-center">
                                        @if ($task->status === 'completed')
                                            <span class="badge badge-status-completed px-3 py-1 rounded-pill fw-bold">{{ __('messages.completed') }}</span>
                                            @if($task->completed_at)
                                                <div class="mt-1 fw-medium" style="font-size: 0.72rem; color: #94a3b8; line-height: 1.2;">
                                                    {{ $task->completed_at->translatedFormat('d M H:i') }}
                                                </div>
                                            @endif
                                        @elseif ($task->status === 'review')
                                            <span class="badge badge-status-review px-3 py-1 rounded-pill fw-bold">{{ __('messages.review') }}</span>
                                        @elseif ($task->status === 'in_progress')
                                            <span class="badge badge-status-in_progress px-3 py-1 rounded-pill fw-bold">{{ __('messages.in_progress') }}</span>
                                        @else
                                            <span class="badge badge-status-pending px-3 py-1 rounded-pill fw-bold">{{ __('messages.pending') }}</span>
                                        @endif
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
</x-app-layout>
