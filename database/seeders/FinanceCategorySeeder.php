<?php

namespace Database\Seeders;

use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use App\Models\FeeType;
use Illuminate\Database\Seeder;

class FinanceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $incomeCategories = ['Tuition Fee', 'Admission Fee', 'Exam Fee', 'Library Fee', 'Lab Fee', 'Hostel Fee', 'Transport Fee', 'Donation', 'Grant', 'Other Income'];
        foreach ($incomeCategories as $cat) {
            IncomeCategory::firstOrCreate(['name' => $cat]);
        }

        $expenseCategories = ['Salaries', 'Utilities', 'Maintenance', 'Stationery', 'Events', 'Equipment', 'Transport', 'Rent', 'Other Expense'];
        foreach ($expenseCategories as $cat) {
            ExpenseCategory::firstOrCreate(['name' => $cat]);
        }

        $feeTypes = [
            ['name' => 'Tuition Fee',   'frequency' => 'semester'],
            ['name' => 'Admission Fee', 'frequency' => 'one_time'],
            ['name' => 'Exam Fee',      'frequency' => 'semester'],
            ['name' => 'Library Fee',   'frequency' => 'annual'],
            ['name' => 'Lab Fee',       'frequency' => 'semester'],
        ];
        foreach ($feeTypes as $fee) {
            FeeType::firstOrCreate(['name' => $fee['name']], $fee);
        }

        $this->command->info('Finance categories and fee types seeded.');
    }
}
