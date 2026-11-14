<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Designations
        Schema::create('designations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Work Shifts
        Schema::create('work_shifts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('grace_minutes')->default(10);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Staff
        Schema::create('staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('employee_id', 50)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('dob')->nullable();
            $table->string('blood_group', 5)->nullable();
            $table->string('religion', 50)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('personal_email')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->foreignUuid('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('designation_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('work_shift_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('employment_type', ['permanent', 'contract', 'part_time', 'visiting'])->default('permanent');
            $table->date('join_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->string('highest_degree')->nullable();
            $table->string('institution')->nullable();
            $table->string('year_of_passing', 4)->nullable();
            $table->string('specialization')->nullable();
            $table->integer('experience_years')->default(0);
            $table->boolean('is_teacher')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('custom_fields')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_teacher', 'is_active']);
        });

        // Staff Notes
        Schema::create('staff_notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('staff_id')->constrained()->cascadeOnDelete();
            $table->text('note');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Leave Types
        Schema::create('leave_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->integer('days_allowed')->default(0);
            $table->enum('applies_to', ['staff', 'student', 'all'])->default('staff');
            $table->boolean('is_paid')->default(true);
            $table->boolean('carry_forward')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Leave Applications
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('applicant_id')->constrained('users')->cascadeOnDelete();
            $table->enum('applicant_type', ['staff', 'student'])->default('staff');
            $table->foreignUuid('leave_type_id')->constrained()->cascadeOnDelete();
            $table->date('from_date');
            $table->date('to_date');
            $table->decimal('days_count', 5, 1)->default(1);
            $table->text('reason')->nullable();
            $table->string('document')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Leave Balances
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('staff_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('leave_type_id')->constrained()->cascadeOnDelete();
            $table->year('year');
            $table->decimal('entitlement', 5, 1)->default(0);
            $table->decimal('used', 5, 1)->default(0);
            $table->decimal('balance', 5, 1)->default(0);
            $table->timestamps();

            $table->unique(['staff_id', 'leave_type_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
        Schema::dropIfExists('leave_applications');
        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('staff_notes');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('work_shifts');
        Schema::dropIfExists('designations');
    }
};
