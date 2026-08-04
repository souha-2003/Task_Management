<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="d-flex align-items-center justify-content-between gap-2 mb-4">
                <h2 class="fw-bold mb-0 text-dark responsive-title">⚙️ {{ __('messages.manage_user_roles' ?? 'Manage Roles & Permissions') }}: {{ $user->name }}</h2>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-3 fw-semibold text-nowrap">
                    &larr; {{ __('messages.back_to_list' ?? 'Back to List') }}
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <!-- User Info -->
                        <div class="mb-4 p-3 bg-light rounded border">
                            <span class="d-block fw-bold text-dark">{{ __('messages.username' ?? 'Username') }}: {{ $user->name }}</span>
                            <span class="d-block text-secondary">{{ __('messages.email' ?? 'Email') }}: {{ $user->email }}</span>
                        </div>

                        <!-- Roles Checkboxes -->
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark border-bottom pb-2">🎭 {{ __('messages.roles' ?? 'Roles') }}</h5>
                            <div class="row mt-2">
                                @foreach($roles as $role)
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                            <label class="form-check-label cursor-pointer fw-semibold text-capitalize" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('roles')" />
                        </div>

                        <!-- Direct Permissions Checkboxes -->
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark border-bottom pb-2">🔑 {{ __('messages.direct_permissions_explain' ?? 'Direct Permissions (Exceptions)') }}</h5>
                            <p class="text-muted small">{{ __('messages.direct_permissions_hint' ?? 'Note: You only need to assign these if you want to grant a permission directly to this user, bypassing their role.') }}</p>
                            <div class="row mt-2">
                                @foreach($permissions as $permission)
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" {{ $user->hasDirectPermission($permission->name) ? 'checked' : '' }}>
                                            <label class="form-check-label cursor-pointer" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('permissions')" />
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4 fw-semibold border">
                                {{ __('messages.cancel' ?? 'Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                                {{ __('messages.save' ?? 'Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        .responsive-title {
            font-size: 1.4rem;
            white-space: nowrap;
        }
        @media (max-width: 992px) {
            .responsive-title {
                font-size: 1.2rem !important;
            }
        }
        @media (max-width: 768px) {
            .responsive-title {
                font-size: 1rem !important;
            }
        }
        @media (max-width: 576px) {
            .responsive-title {
                font-size: 0.98rem !important;
            }
        }
    </style>
</x-app-layout>
