<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('semester_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('session_course_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_marks', 6, 2)->default(0);
            $table->decimal('obtained_marks', 6, 2)->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->string('letter_grade', 5)->nullable();
            $table->foreignUuid('grade_rule_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('gpa_point', 4, 2)->default(0);
            $table->decimal('credit_hours', 4, 2)->default(0);
            $table->boolean('is_pass')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('published_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['student_id', 'session_course_id']);
        });

        Schema::create('student_semester_summaries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('semester_id')->constrained()->cascadeOnDelete();
            $table->decimal('semester_gpa', 4, 2)->default(0);
            $table->decimal('cgpa', 4, 2)->default(0);
            $table->integer('total_credits_attempted')->default(0);
            $table->integer('total_credits_earned')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->unique(['student_id', 'semester_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_semester_summaries');
        Schema::dropIfExists('student_results');
    }
};
