<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('icon', 10)->default('📄');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('study_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_course_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('content_type_id')->constrained()->restrictOnDelete();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('file_path', 500)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->foreignId('uploaded_by')->constrained('users')->restrictOnDelete();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_course_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->dateTime('due_date');
            $table->decimal('max_marks', 6, 2)->nullable();
            $table->string('attachment_path', 500)->nullable();
            $table->boolean('is_published')->default(true);
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('study_contents');
        Schema::dropIfExists('content_types');
    }
};
