<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UpdateAdminUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserApiController extends Controller
{
    /**
     * Display a listing of the users (For Admins).
     */
    public function index()
    {
        Gate::authorize('manage users');

        // Load users with their roles and permissions
        $users = User::with(['roles.permissions', 'permissions'])->get();

        return UserResource::collection($users);
    }

    /**
     * Update the specified user's roles and permissions (For Admins).
     */
    public function update(UpdateAdminUserRequest $request, User $user)
    {
        Gate::authorize('manage users');

        // Sync Roles
        $roles = $request->roles ?? [];
        $user->syncRoles($roles);

        // Sync Direct Permissions
        $permissions = $request->permissions ?? [];
        $user->syncPermissions($permissions);

        $user->load(['roles.permissions', 'permissions']);

        return new UserResource($user);
    }
}
