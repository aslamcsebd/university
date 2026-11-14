<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grading_systems', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('max_gpa', 4, 2)->default(4.00);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('grade_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('grading_system_id')->constrained()->cascadeOnDelete();
            $table->string('letter_grade', 5);
            $table->decimal('min_percentage', 5, 2);
            $table->decimal('max_percentage', 5, 2);
            $table->decimal('gpa_point', 4, 2);
            $table->boolean('is_pass')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_rules');
        Schema::dropIfExists('grading_systems');
    }
};
