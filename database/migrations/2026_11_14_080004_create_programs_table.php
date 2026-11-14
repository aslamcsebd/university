<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('department_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('short_name', 20)->unique();
            $table->string('code', 20)->nullable()->unique();
            $table->enum('level', ['certificate', 'diploma', 'bachelor', 'master', 'phd', 'other'])->default('bachelor');
            $table->decimal('duration_years', 3, 1)->default(4.0);
            $table->integer('total_credits')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('batches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('program_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('academic_session_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->smallInteger('intake_year')->nullable();
            $table->integer('max_students')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['program_id', 'name']);
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('batch_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('semester_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 50);
            $table->integer('capacity')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
        Schema::dropIfExists('batches');
        Schema::dropIfExists('programs');
    }
};
