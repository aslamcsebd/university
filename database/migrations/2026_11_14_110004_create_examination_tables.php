<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('semester_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('mark_distributions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('session_course_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('exam_type_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_marks', 6, 2);
            $table->decimal('pass_marks', 6, 2)->nullable();
            $table->decimal('weightage', 5, 2)->default(100);
            $table->timestamps();

            $table->unique(['session_course_id', 'exam_type_id']);
        });

        Schema::create('student_marks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('mark_distribution_id')->constrained()->cascadeOnDelete();
            $table->decimal('marks_obtained', 6, 2)->nullable();
            $table->boolean('is_absent')->default(false);
            $table->foreignId('entered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['student_id', 'mark_distribution_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_marks');
        Schema::dropIfExists('mark_distributions');
        Schema::dropIfExists('exam_types');
    }
};
