<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('book_categories')->restrictOnDelete();
            $table->string('title', 500);
            $table->string('author', 255)->nullable();
            $table->string('publisher', 255)->nullable();
            $table->string('isbn', 50)->nullable()->unique();
            $table->string('edition', 50)->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('available')->default(1);
            $table->string('shelf_no', 50)->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('library_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->string('person_type', 20); // student / staff / outsider
            $table->string('member_no', 50)->unique();
            $table->string('name', 200);
            $table->string('email', 200)->nullable();
            $table->string('phone', 30)->nullable();
            $table->date('valid_until');
            $table->unsignedTinyInteger('max_books')->default(3);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->restrictOnDelete();
            $table->foreignId('member_id')->constrained('library_members')->restrictOnDelete();
            $table->foreignId('issued_by')->constrained('users')->restrictOnDelete();
            $table->date('issue_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->decimal('fine_amount', 8, 2)->default(0);
            $table->boolean('fine_paid')->default(false);
            $table->string('status', 20)->default('issued'); // issued / returned / overdue
            $table->timestamps();
        });

        Schema::create('book_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('library_members')->restrictOnDelete();
            $table->string('book_title', 500);
            $table->string('author', 255)->nullable();
            $table->text('reason')->nullable();
            $table->string('status', 20)->default('pending'); // pending / approved / rejected
            $table->timestamps();
        });

        Schema::create('library_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('student_issue_days')->default(14);
            $table->unsignedTinyInteger('staff_issue_days')->default(30);
            $table->unsignedTinyInteger('max_books_student')->default(3);
            $table->unsignedTinyInteger('max_books_staff')->default(5);
            $table->decimal('fine_per_day', 6, 2)->default(5.00);
            $table->decimal('max_fine_per_book', 8, 2)->default(200.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_settings');
        Schema::dropIfExists('book_requests');
        Schema::dropIfExists('book_issues');
        Schema::dropIfExists('library_members');
        Schema::dropIfExists('books');
        Schema::dropIfExists('book_categories');
    }
};
