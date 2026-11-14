<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('university_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('room_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('campus_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->integer('floors')->default(1);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('building_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('room_type_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 100);
            $table->integer('floor')->default(1);
            $table->integer('capacity')->default(30);
            $table->boolean('has_projector')->default(false);
            $table->boolean('has_ac')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['building_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('buildings');
        Schema::dropIfExists('room_types');
        Schema::dropIfExists('campuses');
    }
};
