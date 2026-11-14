<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hostels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 200);
            $table->string('type', 10)->default('mixed'); // male / female / mixed
            $table->foreignId('warden_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('hostel_room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->unsignedTinyInteger('capacity')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('hostel_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hostel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_type_id')->constrained('hostel_room_types')->restrictOnDelete();
            $table->string('room_number', 20);
            $table->string('floor', 20)->nullable();
            $table->unsignedTinyInteger('capacity');
            $table->unsignedTinyInteger('current_occupants')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->unique(['hostel_id', 'room_number']);
        });

        Schema::create('hostel_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('hostel_rooms')->restrictOnDelete();
            $table->unsignedBigInteger('person_id');
            $table->string('person_type', 10); // student / staff
            $table->date('move_in_date');
            $table->date('move_out_date')->nullable();
            $table->string('status', 10)->default('active'); // active / vacated
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
