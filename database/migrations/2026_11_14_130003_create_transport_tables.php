<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_no', 30)->unique();
            $table->string('type', 10)->default('bus'); // bus / van / car
            $table->unsignedSmallInteger('capacity');
            $table->string('model', 100)->nullable();
            $table->year('year')->nullable();
            $table->foreignId('driver_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('transport_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->restrictOnDelete();
            $table->string('name', 200);
            $table->string('from_location', 200);
            $table->string('to_location', 200);
            $table->decimal('fare', 8, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('transport_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('transport_routes')->cascadeOnDelete();
            $table->string('name', 200);
            $table->unsignedTinyInteger('order')->default(1);
            $table->time('pickup_time')->nullable();
            $table->timestamps();
        });

        Schema::create('transport_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('transport_routes')->restrictOnDelete();
            $table->unsignedBigInteger('person_id');
            $table->string('person_type', 10); // student / staff
            $table->foreignId('stop_id')->nullable()->constrained('transport_stops')->nullOnDelete();
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
