<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('department_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->decimal('credit_hours', 4, 2)->default(3.0);
            $table->enum('type', ['core', 'elective', 'lab', 'thesis', 'other'])->default('core');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('course_prerequisites', function (Blueprint $table) {
            $table->foreignUuid('course_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('prerequisite_id')->constrained('courses')->cascadeOnDelete();
            $table->primary(['course_id', 'prerequisite_id']);
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('course_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 50)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('session_courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('semester_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('course_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('section_id')->nullable()->constrained()->nullOnDelete();
            $table->string('teacher_id')->nullable();
            $table->foreignUuid('room_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['semester_id', 'course_id', 'section_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_courses');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('course_prerequisites');
        Schema::dropIfExists('courses');
    }
};
