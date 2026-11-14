<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('location', 200)->nullable();
            $table->foreignId('incharge_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('contact_person', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 200)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('item_categories')->restrictOnDelete();
            $table->foreignId('store_id')->constrained()->restrictOnDelete();
            $table->string('name', 255);
            $table->string('code', 50)->nullable()->unique();
            $table->string('unit', 50)->default('pcs');
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('min_threshold', 10, 2)->default(0);
            $table->boolean('is_consumable')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('item_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->restrictOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->date('purchase_date');
            $table->string('invoice_no', 100)->nullable();
            $table->foreignId('received_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });

        Schema::create('item_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->restrictOnDelete();
            $table->decimal('quantity', 10, 2);
            $table->unsignedBigInteger('issued_to_id')->nullable();
            $table->string('issued_to_type', 20)->nullable(); // staff / student / dept
            $table->string('purpose', 500)->nullable();
            $table->date('expected_return_date')->nullable();
            $table->foreignId('issued_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('issued_at');
            $table->timestamps();
        });

        Schema::create('item_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_issue_id')->constrained()->restrictOnDelete();
            $table->decimal('quantity_returned', 10, 2);
            $table->string('condition', 50)->nullable();
            $table->timestamp('returned_at');
            $table->foreignId('received_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_returns');
        Schema::dropIfExists('item_issues');
        Schema::dropIfExists('item_stocks');
        Schema::dropIfExists('items');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('item_categories');
    }
};
