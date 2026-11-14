<?php

namespace Database\Seeders;

use App\Models\Designation;
use App\Models\WorkShift;
use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    public function run(): void
    {
        $designations = ['Professor', 'Associate Professor', 'Assistant Professor', 'Lecturer', 'Senior Lecturer', 'Admin Officer', 'Accountant', 'IT Officer', 'Librarian', 'Driver', 'Security Guard', 'Peon'];
        foreach ($designations as $d) {
            Designation::firstOrCreate(['name' => $d]);
        }

        WorkShift::firstOrCreate(['name' => 'Morning'], ['start_time' => '08:00', 'end_time' => '16:00', 'grace_minutes' => 10]);
        WorkShift::firstOrCreate(['name' => 'Evening'], ['start_time' => '14:00', 'end_time' => '22:00', 'grace_minutes' => 10]);
        WorkShift::firstOrCreate(['name' => 'Full Day'], ['start_time' => '09:00', 'end_time' => '17:00', 'grace_minutes' => 15]);

        LeaveType::firstOrCreate(['name' => 'Annual Leave'],  ['days_allowed' => 20, 'applies_to' => 'staff', 'is_paid' => true,  'carry_forward' => true]);
        LeaveType::firstOrCreate(['name' => 'Sick Leave'],    ['days_allowed' => 14, 'applies_to' => 'staff', 'is_paid' => true,  'carry_forward' => false]);
        LeaveType::firstOrCreate(['name' => 'Casual Leave'],  ['days_allowed' => 10, 'applies_to' => 'staff', 'is_paid' => true,  'carry_forward' => false]);
        LeaveType::firstOrCreate(['name' => 'Maternity Leave'],['days_allowed' => 90, 'applies_to' => 'staff', 'is_paid' => true, 'carry_forward' => false]);
        LeaveType::firstOrCreate(['name' => 'Unpaid Leave'],  ['days_allowed' => 30, 'applies_to' => 'all',   'is_paid' => false, 'carry_forward' => false]);

        $this->command->info('Designations, shifts and leave types seeded.');
    }
}
