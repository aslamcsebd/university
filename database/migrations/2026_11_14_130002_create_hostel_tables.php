<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hostels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('campus_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->enum('type', ['male', 'female', 'mixed'])->default('mixed');
            $table->string('warden_id', 36)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('hostel_room_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->integer('capacity')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('hostel_rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('hostel_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('room_type_id')->nullable()->constrained('hostel_room_types')->nullOnDelete();
            $table->string('room_number', 50);
            $table->integer('floor')->default(1);
            $table->integer('capacity')->default(1);
            $table->integer('current_occupants')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('hostel_allocations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('room_id')->constrained('hostel_rooms')->cascadeOnDelete();
            $table->string('person_id', 36);
            $table->enum('person_type', ['student', 'staff'])->default('student');
            $table->date('move_in_date');
            $table->date('move_out_date')->nullable();
            $table->enum('status', ['active', 'vacated'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostel_allocations');
        Schema::dropIfExists('hostel_rooms');
        Schema::dropIfExists('hostel_room_types');
        Schema::dropIfExists('hostels');
    }
};
