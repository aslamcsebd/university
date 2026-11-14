<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Lecture Hall', 'Laboratory', 'Seminar Room', 'Office', 'Library', 'Computer Lab', 'Conference Room', 'Auditorium'];
        foreach ($types as $type) {
            RoomType::firstOrCreate(['name' => $type]);
        }
        $this->command->info('Room types seeded.');
    }
}
