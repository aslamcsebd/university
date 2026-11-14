<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Salary Structures
        Schema::create('salary_structures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('staff_id')->constrained()->cascadeOnDelete();
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->decimal('house_allowance', 12, 2)->default(0);
            $table->decimal('transport_allowance', 12, 2)->default(0);
            $table->decimal('medical_allowance', 12, 2)->default(0);
            $table->json('other_allowances')->nullable();
            $table->decimal('provident_fund_pct', 5, 2)->default(0);
            $table->decimal('loan_deduction', 12, 2)->default(0);
            $table->date('effective_from');
            $table->timestamps();
        });

        // Tax Settings
        Schema::create('tax_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->json('slabs'); // [{min, max, rate}]
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // Payrolls
        Schema::create('payrolls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('staff_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('month');
            $table->smallInteger('year');
            $table->decimal('basic', 12, 2)->default(0);
            $table->decimal('gross', 12, 2)->default(0);
            $table->json('allowances')->nullable();
            $table->json('deductions')->nullable();
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2)->default(0);
            $table->integer('absent_days')->default(0);
            $table->integer('working_days')->default(26);
            $table->enum('status', ['draft', 'approved', 'paid'])->default('draft');
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['staff_id', 'month', 'year']);
            $table->index(['month', 'year', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
        Schema::dropIfExists('tax_settings');
        Schema::dropIfExists('salary_structures');
    }
};
