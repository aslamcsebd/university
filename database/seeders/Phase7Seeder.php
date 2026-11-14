<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use App\Models\ContentType;
use App\Models\ItemCategory;
use App\Models\Store;
use Illuminate\Database\Seeder;

class Phase7Seeder extends Seeder
{
    public function run(): void
    {
        // Book Categories
        $bookCats = ['Fiction','Non-Fiction','Science','Mathematics','Engineering','Medical','Arts','History','Biography','Reference'];
        foreach ($bookCats as $cat) BookCategory::firstOrCreate(['name' => $cat]);

        // Content Types
        $types = ['Lecture Notes','Slides','Past Papers','Reference Book','Video Lecture','Assignment','Lab Manual','Other'];
        foreach ($types as $t) ContentType::firstOrCreate(['name' => $t]);

        // Item Categories
        $itemCats = ['Stationery','Electronics','Furniture','Lab Equipment','Cleaning Supplies','Sports Equipment','Medical Supplies','Other'];
        foreach ($itemCats as $cat) ItemCategory::firstOrCreate(['name' => $cat]);

        // Default Store
        Store::firstOrCreate(['name' => 'Main Store'], ['location' => 'Admin Block', 'description' => 'Main inventory store']);

        $this->command->info('Phase 7 seed data created.');
    }
}
