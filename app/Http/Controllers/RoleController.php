<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function index()
    {
        Gate::authorize('manage roles');
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        Gate::authorize('manage roles');
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        Gate::authorize('manage roles');

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', __('Role created successfully!'));
    }

    public function edit(Role $role)
    {
        Gate::authorize('manage roles');
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        Gate::authorize('manage roles');

        if ($role->name !== 'admin') {
            $role->update(['name' => $request->name]);
        }

        $permissions = $request->permissions ?? [];
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', __('Role updated successfully!'));
    }

    public function destroy(Role $role)
    {
        Gate::authorize('manage roles');

        $role->delete();
        return redirect()->route('roles.index')->with('success', __('Role deleted successfully!'));
    }
}
