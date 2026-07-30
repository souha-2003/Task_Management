<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\UpdateAdminUserRequest;

class AdminUserController extends Controller
{
    public function index()
    {
        Gate::authorize('manage users');
        $users = User::with(['roles.permissions', 'permissions'])->get();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        Gate::authorize('manage users');
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(UpdateAdminUserRequest $request, User $user)
    {
        Gate::authorize('manage users');

        // Sync Roles
        $roles = $request->roles ?? [];
        $user->syncRoles($roles);

        // Sync Direct Permissions
        $permissions = $request->permissions ?? [];
        $user->syncPermissions($permissions);

        return redirect()->route('admin.users.index')->with('success', __('User roles and permissions updated successfully!'));
    }
}
