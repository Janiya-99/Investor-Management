<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Users permissions
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            
            // Roles permissions
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            
            // Permissions permissions
            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',
            
            // Investors permissions
            'investors.view',
            'investors.create',
            'investors.edit',
            'investors.delete',
            
            // Products permissions
            'products.view',
            'products.create',
            'products.edit',
            'products.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'users.view',
            'users.create',
            'users.edit',
            'investors.view',
            'investors.create',
            'investors.edit',
            'products.view',
            'products.create',
            'products.edit',
        ]);

        $manager = Role::create(['name' => 'Investor', 'guard_name' => 'web']);
        $manager->givePermissionTo([
            'investors.view',
            'investors.create',
            'investors.edit',
            'products.view',
        ]);

        $userRole = Role::create(['name' => 'User', 'guard_name' => 'web']);
        $userRole->givePermissionTo([
            'investors.view',
            'products.view',
        ]);

        // Assign Super Admin role to the default admin user if it exists
        $adminUser = User::where('email', 'admin@phoenixcoded.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('Super Admin');
            $this->command->info('Super Admin role assigned to admin@phoenixcoded.com');
        }

        $this->command->info('Roles and Permissions seeded successfully!');
    }
}

