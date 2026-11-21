<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CustomAuthorizationSeeder::class,
            UniversitySeeder::class,
            AdminUserSeeder::class,
            DepartmentUserSeeder::class,
        ]);
    }
}
