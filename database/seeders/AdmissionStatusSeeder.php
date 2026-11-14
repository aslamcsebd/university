<?php

namespace Database\Seeders;

use App\Models\AdmissionStatus;
use Illuminate\Database\Seeder;

class AdmissionStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Submitted',   'color' => '#6b7280', 'is_approval_trigger' => false, 'order' => 1],
            ['name' => 'Reviewed',    'color' => '#3b82f6', 'is_approval_trigger' => false, 'order' => 2],
            ['name' => 'Shortlisted', 'color' => '#8b5cf6', 'is_approval_trigger' => false, 'order' => 3],
            ['name' => 'Approved',    'color' => '#16a34a', 'is_approval_trigger' => true,  'order' => 4],
            ['name' => 'Rejected',    'color' => '#dc2626', 'is_approval_trigger' => false, 'order' => 5],
            ['name' => 'Waitlisted',  'color' => '#d97706', 'is_approval_trigger' => false, 'order' => 6],
        ];

        foreach ($statuses as $status) {
            AdmissionStatus::firstOrCreate(['name' => $status['name']], $status);
        }

        $this->command->info('Admission statuses seeded.');
    }
}
