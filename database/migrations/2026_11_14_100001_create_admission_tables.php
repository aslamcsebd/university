<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Admission Status Types
        Schema::create('admission_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('color', 20)->default('#6b7280');
            $table->text('description')->nullable();
            $table->boolean('is_approval_trigger')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Admission Applications
        Schema::create('admission_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('program_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('academic_session_id')->nullable()->constrained()->nullOnDelete();
            $table->string('applicant_name');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->json('documents')->nullable();
            $table->json('custom_fields')->nullable();
            $table->foreignUuid('status_id')->nullable()->constrained('admission_statuses')->nullOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['program_id', 'email']);
        });

        // Admission Status History
        Schema::create('admission_status_history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('admission_applications')->cascadeOnDelete();
            $table->foreignUuid('status_id')->nullable()->constrained('admission_statuses')->nullOnDelete();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admission_status_history');
        Schema::dropIfExists('admission_applications');
        Schema::dropIfExists('admission_statuses');
    }
};
