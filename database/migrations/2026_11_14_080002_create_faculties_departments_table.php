<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('short_name', 10)->unique();
            $table->string('code', 20)->nullable()->unique();
            $table->string('dean_id')->nullable(); // FK to staff (added later)
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('name');
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('faculty_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('short_name', 50)->nullable();
            $table->string('code', 20)->nullable();
            $table->enum('type', ['academic', 'hr', 'admin'])->default('academic');
            $table->string('head_id')->nullable(); // FK to staff (added later)
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
        Schema::dropIfExists('faculties');
    }
};
