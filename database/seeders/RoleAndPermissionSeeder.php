<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reset Cached Roles and Permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Define Permissions based on uploaded Policy files
        $permissions = [
            // User Permissions
            'user-list', 'user-create', 'user-edit', 'user-delete',
            // Role Permissions
            'role-list', 'role-create', 'role-edit', 'role-delete',
            // Permission Permissions
            'permission-list', 'permission-create', 'permission-edit', 'permission-delete',
        ];

        // 3. Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['description' => 'Allows user to ' . str_replace('-', ' ', $permission)] 
            );
        }

        // 4. Create Roles
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'Super Admin', 'guard_name' => 'web'],
            ['description' => 'Has all permissions']
        );
        
        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['description' => 'System administrator']
        );
        
        $staffRole = Role::firstOrCreate(
            ['name' => 'Staff', 'guard_name' => 'web'],
            ['description' => 'Standard staff member']
        );

        // 5. Assign Permissions to Roles
        $superAdminRole->syncPermissions($permissions);
        $adminRole->syncPermissions($permissions);

        $staffRole->syncPermissions([
            'user-list',
            'role-list',
            'permission-list',
        ]);

        $this->command->info('Roles and Permissions seeded successfully.');
    }
}