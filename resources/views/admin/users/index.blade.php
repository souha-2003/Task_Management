<x-app-layout>
    <div class="row mb-4 align-items-center">
        <div class="col-md-12">
            <h2 class="fw-bold mb-0 text-dark">👥 {{ __('messages.users_management' ?? 'Users Management') }}</h2>
        </div>
    </div>

    <!-- Users List Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="py-3 px-4">{{ __('messages.username' ?? 'Username') }}</th>
                            <th scope="col" class="py-3 d-none d-md-table-cell">{{ __('messages.email' ?? 'Email') }}</th>
                            <th scope="col" class="py-3">{{ __('messages.roles' ?? 'Roles') }}</th>
                            <th scope="col" class="py-3 d-none d-md-table-cell">{{ __('messages.permissions' ?? 'Permissions') }}</th>
                            <th scope="col" class="py-3 text-center px-4">{{ __('messages.actions' ?? 'Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td data-label="{{ __('messages.username' ?? 'Username') }}" class="px-4 fw-bold text-dark">
                                    {{ $user->name }}
                                </td>
                                <td data-label="{{ __('messages.email' ?? 'Email') }}" class="text-secondary d-none d-md-table-cell">
                                    {{ $user->email }}
                                </td>
                                <td data-label="{{ __('messages.roles' ?? 'Roles') }}">
                                    @if($user->roles->isEmpty())
                                        <span class="badge bg-light text-secondary border">{{ __('messages.no_roles' ?? 'No Roles') }}</span>
                                    @else
                                        @foreach($user->roles as $role)
                                            <span class="badge bg-primary text-white">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                <td data-label="{{ __('messages.permissions' ?? 'Permissions') }}" class="d-none d-md-table-cell">
                                    @if($user->getAllPermissions()->isEmpty())
                                        <span class="text-muted small">-</span>
                                    @else
                                        @foreach($user->getAllPermissions() as $permission)
                                            <span class="badge bg-light text-dark border">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                <td data-label="{{ __('messages.actions' ?? 'Actions') }}" class="text-center px-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-warning btn-sm px-3 fw-semibold">
                                            ⚙️ {{ __('messages.manage_roles' ?? 'Roles & Permissions') }}
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
</x-app-layout>
