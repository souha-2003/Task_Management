<x-app-layout>
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark mb-1">👋 {{ __('messages.welcome') }}, {{ Auth::user()->name }}!</h2>
            <p class="text-secondary mb-0">{{ __('Here is a quick overview of your task management activity today.') }}</p>
        </div>
    </div>

    @if ($totalTasks === 0)
        <!-- Empty State Welcome Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 p-5 text-center">
                    <div class="fs-2 mb-3">🎯</div>
                    <h3 class="fw-bold text-dark mb-2">{{ __('messages.welcome') }}!</h3>
                    <p class="text-secondary mb-4">{{ __('You do not have any tasks yet. Create your first task to get started and manage your work efficiently.') }}</p>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm d-flex align-items-center gap-2">
                            ➕ {{ __('messages.create_task') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Stats Cards Grid -->
        <div class="row g-4 mb-4">
            <!-- Total Tasks -->
        <!-- Stats Cards -->
        <div class="row mb-4 g-3">
            <!-- Total Tasks -->
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #4f46e5 !important;">
                    <div class="card-body py-3 px-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-secondary text-uppercase fw-semibold small mb-1" style="font-size: 0.75rem;">{{ __('Total Tasks') }}</h6>
                                <h4 class="fw-bold mb-0 text-dark">{{ $totalTasks }}</h4>
                            </div>
                            <div class="fs-4">📋</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #6b7280 !important;">
                    <div class="card-body py-3 px-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-secondary text-uppercase fw-semibold small mb-1" style="font-size: 0.75rem;">{{ __('messages.pending') }}</h6>
                                <h4 class="fw-bold mb-0 text-dark">{{ $pendingTasks }}</h4>
                            </div>
                            <div class="fs-4">⏳</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- In Progress Tasks -->
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #0ea5e9 !important;">
                    <div class="card-body py-3 px-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-secondary text-uppercase fw-semibold small mb-1" style="font-size: 0.75rem;">{{ __('messages.in_progress') }}</h6>
                                <h4 class="fw-bold mb-0 text-dark">{{ $inProgressTasks }}</h4>
                            </div>
                            <div class="fs-4">⚡</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Tasks -->
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #f59e0b !important;">
                    <div class="card-body py-3 px-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-secondary text-uppercase fw-semibold small mb-1" style="font-size: 0.75rem;">{{ __('messages.review') }}</h6>
                                <h4 class="fw-bold mb-0 text-dark">{{ $reviewTasks }}</h4>
                            </div>
                            <div class="fs-4">🔍</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Tasks -->
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #10b981 !important;">
                    <div class="card-body py-3 px-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-secondary text-uppercase fw-semibold small mb-1" style="font-size: 0.75rem;">{{ __('messages.completed') }}</h6>
                                <h4 class="fw-bold mb-0 text-dark">{{ $completedTasks }}</h4>
                            </div>
                            <div class="fs-4">✅</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #3b82f6 !important;">
                    <div class="card-body py-3 px-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-secondary text-uppercase fw-semibold small mb-1" style="font-size: 0.75rem;">{{ __('messages.categories') }}</h6>
                                <h4 class="fw-bold mb-0 text-dark">{{ $totalCategories }}</h4>
                            </div>
                            <div class="fs-4">🏷️</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Task Row -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-0">
                        <h5 class="fw-bold mb-0 text-dark">🕒 {{ __('Most Recent Task') }}</h5>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary btn-sm px-3 fw-semibold">
                            {{ __('View All') }} &rarr;
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="py-3 px-4">{{ __('messages.task_title') }}</th>
                                        <th scope="col" class="py-3 text-center">{{ __('messages.status') }}</th>
                                        <th scope="col" class="py-3 text-center px-4">{{ __('messages.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTasks as $task)
                                        <tr>
                                            <td class="px-4 fw-bold text-dark">
                                                <div>{{ $task->title }}</div>
                                                <div class="mt-1 d-flex flex-wrap gap-1">
                                                    @foreach ($task->categories as $category)
                                                        <span class="badge font-monospace" style="font-size: 0.7rem; background-color: {{ $category->color }}1a; color: {{ $category->color }}; border: 1px solid {{ $category->color }}33;">{{ $category->name }}</span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($task->status === 'completed')
                                                    <span class="badge badge-status-completed px-3 py-1 rounded-pill fw-bold">{{ __('messages.completed') }}</span>
                                                @elseif ($task->status === 'review')
                                                    <span class="badge badge-status-review px-3 py-1 rounded-pill fw-bold">{{ __('messages.review') }}</span>
                                                @elseif ($task->status === 'in_progress')
                                                    <span class="badge badge-status-in_progress px-3 py-1 rounded-pill fw-bold">{{ __('messages.in_progress') }}</span>
                                                @else
                                                    <span class="badge badge-status-pending px-3 py-1 rounded-pill fw-bold">{{ __('messages.pending') }}</span>
                                                @endif
                                            </td>
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
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Admin Section (Only visible for Admins) -->
    @if ($showAdminSection)
        <div class="row mb-4">
            <div class="col-12">
                <hr class="my-4 border-secondary border-opacity-10">
                <h4 class="fw-bold text-dark mb-3">⚙️ {{ __('messages.administration' ?? 'System Administration') }}</h4>
                
                <div class="row g-4">
                    <!-- Total Users Stat Card -->
                    @can('manage users')
                    <div class="col-md-6 col-12">
                        <div class="card shadow-sm border-0 h-100 p-3" style="border-left: 4px solid #14b8a6 !important;">
                            <div class="card-body py-3 px-3 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-secondary text-uppercase fw-semibold small mb-1" style="font-size: 0.75rem;">{{ __('messages.users' ?? 'System Users') }}</h6>
                                    <h4 class="fw-bold mb-2 text-dark">{{ $totalUsers }}</h4>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm px-3 font-semibold" style="border: 2px solid #14b8a6 !important; color: #14b8a6 !important; background: transparent;">
                                        👥 {{ __('messages.users_management' ?? 'Manage Users') }}
                                    </a>
                                </div>
                                <div class="fs-3">👥</div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    <!-- Total Roles Stat Card -->
                    @can('manage roles')
                    <div class="col-md-6 col-12">
                        <div class="card shadow-sm border-0 h-100 p-3" style="border-left: 4px solid #a855f7 !important;">
                            <div class="card-body py-3 px-3 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-secondary text-uppercase fw-semibold small mb-1" style="font-size: 0.75rem;">{{ __('messages.roles' ?? 'System Roles') }}</h6>
                                    <h4 class="fw-bold mb-2 text-dark">{{ $totalRoles }}</h4>
                                    <a href="{{ route('roles.index') }}" class="btn btn-sm px-3 font-semibold" style="border: 2px solid #a855f7 !important; color: #a855f7 !important; background: transparent;">
                                        🔑 {{ __('messages.roles_management' ?? 'Manage Roles') }}
                                    </a>
                                </div>
                                <div class="fs-3">🔑</div>
                            </div>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
