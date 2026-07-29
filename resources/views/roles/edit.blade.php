<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="fw-bold mb-0 text-dark">✏️ {{ __('messages.edit_role' ?? 'Edit Role') }}: {{ $role->name }}</h2>
                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary px-3 fw-semibold">
                    &larr; {{ __('messages.back_to_list' ?? 'Back to List') }}
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('roles.update', $role) }}">
                        @csrf
                        @method('PUT')

                        <!-- Role Name -->
                        <div class="mb-4">
                            <x-input-label for="name" value="{{ __('messages.role_name' ?? 'Role Name') }} *" />
                            <x-text-input id="name" type="text" name="name" :value="old('name', $role->name)" required autofocus :readonly="$role->name === 'admin'" />
                            @if($role->name === 'admin')
                                <small class="text-danger d-block mt-1">{{ __('messages.admin_role_cannot_be_renamed' ?? 'The admin role name cannot be modified as it is required by the system.') }}</small>
                            @endif
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <!-- Permissions Checkboxes -->
                        <div class="mb-4">
                            <x-input-label value="{{ __('messages.permissions' ?? 'Permissions') }}" />
                            <div class="row mt-2">
                                @foreach($permissions as $permission)
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
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
                            <a href="{{ route('roles.index') }}" class="btn btn-light px-4 fw-semibold border">
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
    </style>
</x-app-layout>
