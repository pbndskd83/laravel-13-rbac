<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'status' => true,
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('Super Admin');

        // 2. Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'status' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('Admin');

        // 3. Staff Member
        $staff = User::firstOrCreate(
            ['email' => 'staff@gmail.com'],
            [
                'name' => 'Staff Member',
                'password' => Hash::make('password'),
                'status' => true,
                'email_verified_at' => now(),
            ]
        );
        $staff->assignRole('Staff');

        // 4. Create 10 Dummy Users
        // We exclude 'Super Admin' so random users only get standard roles
        $assignableRoles = ['Admin', 'Staff'];

        User::factory()->count(10)->create([
            'status' => true,
            'password' => Hash::make('password'),
        ])->each(function ($user) use ($assignableRoles) {
            $randomRole = $assignableRoles[array_rand($assignableRoles)];
            $user->assignRole($randomRole);
        });

        $this->command->info('Specific users and 10 dummy users seeded successfully.');
    }
}