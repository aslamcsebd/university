<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('section_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('semester_id')->constrained()->cascadeOnDelete();
            $table->date('enrolled_at');
            $table->enum('status', ['active', 'withdrawn', 'completed'])->default('active');
            $table->date('withdrawn_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'semester_id']);
        });

        Schema::create('student_course_enrollments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('session_course_id')->constrained()->cascadeOnDelete();
            $table->date('enrolled_at');
            $table->enum('status', ['enrolled', 'dropped', 'completed', 'failed'])->default('enrolled');
            $table->timestamps();

            $table->unique(['student_id', 'session_course_id']);
        });

        Schema::create('enrollment_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('semester_id')->constrained()->cascadeOnDelete();
            $table->date('enrollment_start')->nullable();
            $table->date('enrollment_end')->nullable();
            $table->date('withdrawal_deadline')->nullable();
            $table->integer('max_courses_per_semester')->default(8);
            $table->boolean('block_on_fees_due')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollment_settings');
        Schema::dropIfExists('student_course_enrollments');
        Schema::dropIfExists('student_enrollments');
    }
};
