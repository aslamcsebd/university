<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fee Types
        Schema::create('fee_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->enum('frequency', ['one_time', 'monthly', 'semester', 'annual'])->default('semester');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Fee Assignments
        Schema::create('fee_assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('fee_type_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('semester_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('fine_amount', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->date('due_date')->nullable();
            $table->enum('status', ['pending', 'partial', 'paid', 'waived'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'status']);
        });

        // Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('fee_assignment_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'online', 'cheque'])->default('cash');
            $table->string('transaction_ref')->nullable()->unique();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('paid_at')->nullable();
            $table->string('receipt_no', 100)->unique();
            $table->json('gateway_response')->nullable();
            $table->timestamps();

            $table->index('student_id');
        });

        // Income Categories & Incomes
        Schema::create('income_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('incomes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->constrained('income_categories')->cascadeOnDelete();
            $table->string('title', 255);
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->string('reference', 255)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Expense Categories & Expenses
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->constrained('expense_categories')->cascadeOnDelete();
            $table->string('title', 255);
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->string('reference', 255)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Scholarships
        Schema::create('scholarships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->enum('type', ['merit', 'need_based', 'sports', 'disability', 'staff_dependent', 'other'])->default('merit');
            $table->text('description')->nullable();
            $table->enum('value_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('value', 10, 2);
            $table->json('eligibility_criteria')->nullable();
            $table->integer('max_recipients')->default(0);
            $table->date('application_start')->nullable();
            $table->date('application_end')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('scholarship_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('scholarship_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('student_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('semester_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected', 'revoked'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->json('supporting_documents')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['scholarship_id', 'student_id', 'semester_id'], 'scholar_app_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_applications');
        Schema::dropIfExists('scholarships');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('income_categories');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('fee_assignments');
        Schema::dropIfExists('fee_types');
    }
};
