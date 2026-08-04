<x-app-layout>
    <style>
        .badge-direct {
            background-color: rgba(245, 158, 11, 0.07) !important;
            color: #d97706 !important;
            border: 1px solid rgba(245, 158, 11, 0.35) !important;
        }
        .badge-inherited {
            background-color: rgba(14, 165, 233, 0.07) !important;
            color: #0284c7 !important;
            border: 1px solid rgba(14, 165, 233, 0.35) !important;
        }
        .badge-role {
            background-color: rgba(139, 92, 246, 0.08) !important;
            color: #612eb9ff !important;
            border: 1px solid rgba(139, 92, 246, 0.35) !important;
        }
        .badge-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        .badge-direct-dot {
            background-color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.5);
        }
        .badge-inherited-dot {
            background-color: #0284c7;
            border: 1px solid rgba(14, 165, 233, 0.5);
        }
    </style>

    <div class="row mb-4 align-items-center">
        <div class="col-md-12">
            <h2 class="fw-bold mb-1 text-dark">👥 {{ __('messages.users_management' ?? 'Users Management') }}</h2>
            <div class="text-secondary small d-flex flex-wrap gap-3 align-items-center mt-2">
                <span class="fw-semibold">{{ __('messages.permissions' ?? 'Permissions') }}:</span>
                <span class="d-inline-flex align-items-center gap-1">
                    <span class="badge-dot badge-direct-dot"></span>
                    {{ __('messages.direct_permissions_explain' ?? 'Direct Permission') }}
                </span>
                <span class="d-inline-flex align-items-center gap-1">
                    <span class="badge-dot badge-inherited-dot"></span>
                    {{ __('messages.inherited_permission' ?? 'Inherited via Role') }}
                </span>
            </div>
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
                                            <span class="badge badge-role">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                <td data-label="{{ __('messages.permissions' ?? 'Permissions') }}" class="d-none d-md-table-cell">
                                    @php
                                        $directPermissions = $user->getDirectPermissions();
                                        $inheritedPermissions = $user->getPermissionsViaRoles();
                                    @endphp
                                    @if($directPermissions->isEmpty() && $inheritedPermissions->isEmpty())
                                        <span class="text-muted small">-</span>
                                    @else
                                        @foreach($directPermissions as $permission)
                                            <span class="badge badge-direct me-1 mb-1" title="{{ __('messages.direct_permissions_explain' ?? 'Direct Permission') }}">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                        @foreach($inheritedPermissions as $permission)
                                            <span class="badge badge-inherited me-1 mb-1" title="{{ __('messages.inherited_permission' ?? 'Inherited via Role') }}">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                <td data-label="{{ __('messages.actions' ?? 'Actions') }}" class="text-center px-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-warning btn-sm px-3 fw-semibold text-nowrap">
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
