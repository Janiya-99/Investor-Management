<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        $adminUser = User::where('email', 'admin@phoenixcoded.com')->first();

        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Admin',
                'email' => 'admin@phoenixcoded.com',
                'password' => Hash::make('12345678'),
                'status' => true,
            ]);

            $this->command->info('Admin user created successfully.');
        } else {
            $this->command->info('Admin user already exists.');
        }

        // Assign Super Admin role if it exists
        $superAdminRole = \Spatie\Permission\Models\Role::where('name', 'Super Admin')->first();
        
        if ($superAdminRole && !$adminUser->hasRole('Super Admin')) {
            $adminUser->assignRole('Super Admin');
            $this->command->info('Super Admin role assigned to admin@phoenixcoded.com');
        } elseif ($adminUser->hasRole('Super Admin')) {
            $this->command->info('Admin user already has Super Admin role.');
        } else {
            $this->command->warn('Super Admin role not found. Please run RolePermissionSeeder first.');
        }
    }
}



