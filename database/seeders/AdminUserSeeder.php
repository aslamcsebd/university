<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123456789'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $admin->assignRole('super_admin');
        }

        $this->command->info('Admin user seeded: admin@gmail.com / 123456789');
    }
}
