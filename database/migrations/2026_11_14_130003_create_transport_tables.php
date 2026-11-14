<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('plate_no', 30)->unique();
            $table->enum('type', ['bus', 'van', 'car'])->default('bus');
            $table->integer('capacity');
            $table->string('model', 100)->nullable();
            $table->smallInteger('year')->nullable();
            $table->string('driver_id', 36)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('transport_routes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('vehicle_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('from_location', 255)->nullable();
            $table->string('to_location', 255)->nullable();
            $table->decimal('fare', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('transport_stops', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('route_id')->constrained('transport_routes')->cascadeOnDelete();
            $table->string('name');
            $table->integer('order')->default(0);
            $table->time('pickup_time')->nullable();
            $table->timestamps();
        });

        Schema::create('transport_allocations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('route_id')->constrained('transport_routes')->cascadeOnDelete();
            $table->string('person_id', 36);
            $table->enum('person_type', ['student', 'staff'])->default('student');
            $table->string('stop_id', 36)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_allocations');
        Schema::dropIfExists('transport_stops');
        Schema::dropIfExists('transport_routes');
        Schema::dropIfExists('vehicles');
    }
};
