<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 255);
            $table->string('title', 500);
            $table->text('body')->nullable();
            $table->json('data')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'read_at']);
        });

        // Notice Categories
        Schema::create('notice_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('color', 20)->default('#3b82f6');
            $table->timestamps();
        });

        // Notices
        Schema::create('notices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->nullable()->constrained('notice_categories')->nullOnDelete();
            $table->string('title', 500);
            $table->longText('content');
            $table->enum('audience', ['all', 'students', 'staff', 'teachers', 'parents'])->default('all');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->json('attachments')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // Events
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 500);
            $table->text('description')->nullable();
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->string('location', 500)->nullable();
            $table->enum('audience', ['all', 'students', 'staff', 'public'])->default('all');
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // Front Desk
        Schema::create('visit_purposes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('phone', 30)->nullable();
            $table->string('id_number', 100)->nullable();
            $table->foreignUuid('purpose_id')->nullable()->constrained('visit_purposes')->nullOnDelete();
            $table->string('host_id', 36)->nullable();
            $table->datetime('check_in');
            $table->datetime('check_out')->nullable();
            $table->string('badge_no', 50)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('enquiry_sources', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('enquiries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->foreignUuid('program_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('source_id')->nullable()->constrained('enquiry_sources')->nullOnDelete();
            $table->string('assigned_to', 36)->nullable();
            $table->date('follow_up_date')->nullable();
            $table->enum('status', ['new', 'in_progress', 'converted', 'closed'])->default('new');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('complaint_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('complaints', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('complainant_name', 255);
            $table->string('phone', 30)->nullable();
            $table->foreignUuid('type_id')->nullable()->constrained('complaint_types')->nullOnDelete();
            $table->string('assigned_to', 36)->nullable();
            $table->text('description');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->text('resolution_notes')->nullable();
            $table->timestamps();
        });

        // Document Generations (Transcripts)
        Schema::create('document_generations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained()->cascadeOnDelete();
            $table->enum('document_type', ['marksheet', 'transcript', 'certificate', 'completion'])->default('transcript');
            $table->foreignUuid('semester_id')->nullable()->constrained()->nullOnDelete();
            $table->string('file_path')->nullable();
            $table->string('certificate_no')->nullable()->unique();
            $table->boolean('is_duplicate')->default(false);
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('generated_at')->useCurrent();
            $table->timestamps();
        });

        // Front Website CMS
        Schema::create('sliders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('cta_text', 100)->nullable();
            $table->string('cta_link', 500)->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('front_news', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 500);
            $table->string('slug', 500)->unique();
            $table->longText('body');
            $table->string('thumbnail', 500)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('front_news');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('document_generations');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('complaint_types');
        Schema::dropIfExists('enquiries');
        Schema::dropIfExists('enquiry_sources');
        Schema::dropIfExists('visitor_logs');
        Schema::dropIfExists('visit_purposes');
        Schema::dropIfExists('events');
        Schema::dropIfExists('notices');
        Schema::dropIfExists('notice_categories');
        Schema::dropIfExists('notifications');
    }
};
