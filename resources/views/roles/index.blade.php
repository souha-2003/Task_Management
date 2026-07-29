<x-app-layout>
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 col-12 mb-3 mb-md-0">
            <h2 class="fw-bold mb-0 text-dark">🔑 {{ __('messages.roles_management' ?? 'Roles Management') }}</h2>
        </div>
        <div class="col-md-6 col-12 text-md-end text-start">
            <a href="{{ route('roles.create') }}" class="btn btn-primary px-4 fw-semibold shadow-sm">
                ➕ {{ __('messages.create_role' ?? 'Create New Role') }}
            </a>
        </div>
    </div>

    <!-- Roles List Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if ($roles->isEmpty())
                <div class="text-center py-5">
                    <h5 class="text-secondary mb-3">{{ __('messages.no_roles' ?? 'No roles found.') }}</h5>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">{{ __('messages.create_role' ?? 'Create Your First Role') }}</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="py-3 px-4">{{ __('messages.role_name' ?? 'Role Name') }}</th>
                                <th scope="col" class="py-3 d-none d-md-table-cell">{{ __('messages.permissions' ?? 'Permissions') }}</th>
                                <th scope="col" class="py-3 text-center px-4">{{ __('messages.actions' ?? 'Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($roles as $role)
                                <tr>
                                    <td data-label="{{ __('messages.role_name' ?? 'Role Name') }}" class="px-4 fw-bold text-dark text-capitalize">
                                        {{ $role->name }}
                                    </td>
                                    <td data-label="{{ __('messages.permissions' ?? 'Permissions') }}" class="d-none d-md-table-cell">
                                        @if($role->permissions->isEmpty())
                                            <span class="text-muted small">{{ __('messages.no_permissions' ?? 'No Permissions') }}</span>
                                        @else
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($role->permissions as $permission)
                                                    <span class="badge bg-light text-dark border px-2 py-1">
                                                        {{ $permission->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('messages.actions' ?? 'Actions') }}" class="text-center px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-outline-warning btn-sm px-3 fw-semibold">
                                                {{ __('messages.edit' ?? 'Edit') }}
                                            </a>
                                            <form method="POST" action="{{ route('roles.destroy', $role) }}" onsubmit="return confirm('{{ __('messages.confirm_delete_role' ?? 'Are you sure you want to delete this role?') }}')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-semibold">
                                                    {{ __('messages.delete' ?? 'Delete') }}
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
</x-app-layout>
