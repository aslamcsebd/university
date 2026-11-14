<?php

namespace Database\Seeders;

use App\Models\University;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        University::firstOrCreate(
            ['name' => 'My University'],
            [
                'short_name'      => 'MU',
                'tagline'         => 'Excellence in Education',
                'address'         => '123 University Road',
                'phone'           => '+1-000-000-0000',
                'email'           => 'info@university.edu',
                'website'         => 'https://university.edu',
                'timezone'        => 'UTC',
                'currency'        => 'USD',
                'currency_symbol' => '$',
            ]
        );

        $defaults = [
            'general.university_name'    => 'My University',
            'general.tagline'            => 'Excellence in Education',
            'general.timezone'           => 'UTC',
            'general.currency'           => 'USD',
            'general.currency_symbol'    => '$',
            'general.date_format'        => 'd M Y',
            'student_panel.show_fees'        => '1',
            'student_panel.show_library'     => '1',
            'student_panel.show_attendance'  => '1',
            'student_panel.show_results'     => '1',
            'student_panel.show_notices'     => '1',
            'student_panel.show_downloads'   => '1',
            'student_panel.show_assignments' => '1',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value, 'group' => explode('.', $key)[0]]);
        }

        $this->command->info('University and default settings seeded.');
    }
}
