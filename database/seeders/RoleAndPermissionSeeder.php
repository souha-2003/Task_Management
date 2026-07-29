<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions using firstOrCreate to avoid errors if run multiple times
        $manageCategories = Permission::firstOrCreate(['name' => 'manage categories']);
        $manageRoles = Permission::firstOrCreate(['name' => 'manage roles']);
        $manageUsers = Permission::firstOrCreate(['name' => 'manage users']);
        $editAnyTask = Permission::firstOrCreate(['name' => 'edit any task']);
        $deleteAnyTask = Permission::firstOrCreate(['name' => 'delete any task']);

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign Permissions to Roles
        $adminRole->syncPermissions([
            $manageCategories,
            $manageRoles,
            $manageUsers,
            $editAnyTask,
            $deleteAnyTask,
        ]);

        // Create or assign roles to test users
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole($adminRole);

        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => bcrypt('password'),
            ]
        );
        $user->assignRole($userRole);
    }
}
