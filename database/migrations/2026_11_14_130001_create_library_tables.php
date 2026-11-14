<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->constrained('book_categories')->cascadeOnDelete();
            $table->string('title', 500);
            $table->string('author', 255)->nullable();
            $table->string('publisher', 255)->nullable();
            $table->string('isbn', 30)->nullable();
            $table->string('edition', 50)->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('available')->default(1);
            $table->string('shelf_no', 50)->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('library_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('person_id', 36);
            $table->enum('person_type', ['student', 'staff', 'outsider'])->default('student');
            $table->string('member_no', 50)->unique();
            $table->date('valid_until')->nullable();
            $table->integer('max_books')->default(3);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['person_id', 'person_type']);
        });

        Schema::create('book_issues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('book_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('member_id')->constrained('library_members')->cascadeOnDelete();
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('issue_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->decimal('fine_amount', 8, 2)->default(0);
            $table->boolean('fine_paid')->default(false);
            $table->enum('status', ['issued', 'returned', 'overdue'])->default('issued');
            $table->timestamps();
        });

        Schema::create('book_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('member_id')->constrained('library_members')->cascadeOnDelete();
            $table->string('book_title', 500);
            $table->string('author', 255)->nullable();
            $table->text('reason')->nullable();
            $table->enum('status', ['pending', 'fulfilled', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_requests');
        Schema::dropIfExists('book_issues');
        Schema::dropIfExists('library_members');
        Schema::dropIfExists('books');
        Schema::dropIfExists('book_categories');
    }
};
