<?php

namespace Database\Seeders;

use App\Models\GradingSystem;
use App\Models\GradeRule;
use Illuminate\Database\Seeder;

class GradingSystemSeeder extends Seeder
{
    public function run(): void
    {
        $system = GradingSystem::firstOrCreate(
            ['name' => 'Standard 4.0 GPA'],
            ['description' => 'Standard university grading scale', 'max_gpa' => 4.00, 'is_default' => true]
        );

        $rules = [
            ['letter_grade'=>'A+','min_percentage'=>90,'max_percentage'=>100,'gpa_point'=>4.00,'is_pass'=>true,'sort_order'=>1],
            ['letter_grade'=>'A', 'min_percentage'=>80,'max_percentage'=>89.99,'gpa_point'=>3.70,'is_pass'=>true,'sort_order'=>2],
            ['letter_grade'=>'B+','min_percentage'=>75,'max_percentage'=>79.99,'gpa_point'=>3.30,'is_pass'=>true,'sort_order'=>3],
            ['letter_grade'=>'B', 'min_percentage'=>70,'max_percentage'=>74.99,'gpa_point'=>3.00,'is_pass'=>true,'sort_order'=>4],
            ['letter_grade'=>'C+','min_percentage'=>65,'max_percentage'=>69.99,'gpa_point'=>2.70,'is_pass'=>true,'sort_order'=>5],
            ['letter_grade'=>'C', 'min_percentage'=>60,'max_percentage'=>64.99,'gpa_point'=>2.30,'is_pass'=>true,'sort_order'=>6],
            ['letter_grade'=>'D', 'min_percentage'=>50,'max_percentage'=>59.99,'gpa_point'=>2.00,'is_pass'=>true,'sort_order'=>7],
            ['letter_grade'=>'F', 'min_percentage'=>0, 'max_percentage'=>49.99,'gpa_point'=>0.00,'is_pass'=>false,'sort_order'=>8],
        ];

        foreach ($rules as $rule) {
            GradeRule::firstOrCreate(
                ['grading_system_id' => $system->id, 'letter_grade' => $rule['letter_grade']],
                array_merge($rule, ['grading_system_id' => $system->id])
            );
        }

        $this->command->info('Default grading system seeded (Standard 4.0 GPA).');
    }
}
