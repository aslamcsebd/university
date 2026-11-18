<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DepartmentUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('Aa@123456');

        $users = [
            [
                'name'  => 'Student Manager',
                'email' => 'student@university.com',
                'role'  => 'student_manager',
                'dept'  => 'Student Management',
            ],
            [
                'name'  => 'Admission Manager',
                'email' => 'admission@university.com',
                'role'  => 'admission_manager',
                'dept'  => 'Admission Management',
            ],
            [
                'name'  => 'Accounting Manager',
                'email' => 'accounting@university.com',
                'role'  => 'accounting_manager',
                'dept'  => 'Accounting Management',
            ],
            [
                'name'  => 'Examination Manager',
                'email' => 'examination@university.com',
                'role'  => 'examination_manager',
                'dept'  => 'Examination Management',
            ],
            [
                'name'  => 'Library Manager',
                'email' => 'library@university.com',
                'role'  => 'library_manager',
                'dept'  => 'Library Management',
            ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'              => $data['name'],
                    'password'          => $password,
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]
            );

            // Remove any old roles and assign the correct one
            $user->syncRoles([$data['role']]);

            $this->command->info("✔  {$data['dept']} user: {$data['email']} / Aa@123456  [{$data['role']}]");
        }
    }
}
