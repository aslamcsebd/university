<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_field_definitions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('applies_to', ['staff', 'student', 'application']);
            $table->string('label', 100);
            $table->string('field_name', 100);
            $table->enum('field_type', ['text', 'textarea', 'number', 'date', 'select', 'checkbox', 'file']);
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('applies_to');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_field_definitions');
    }
};
