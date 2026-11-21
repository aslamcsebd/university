<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['permission_categories', 'roles', 'permissions', 'role_user', 'permission_role', 'permission_user'];
        $existing = array_filter($tables, fn (string $table) => Schema::hasTable($table));

        if (count($existing) === count($tables)) {
            $required = [
                'permission_categories' => ['id', 'name', 'slug'],
                'roles' => ['id', 'name', 'label'],
                'permissions' => ['id', 'name', 'label', 'permission_category_id'],
                'role_user' => ['role_id', 'user_id'],
                'permission_role' => ['permission_id', 'role_id'],
                'permission_user' => ['permission_id', 'user_id'],
            ];
            foreach ($required as $table => $columns) {
                if (! Schema::hasColumns($table, $columns)) {
                    throw new RuntimeException('The existing authorization schema does not match the custom system.');
                }
            }

            return;
        }
        if ($existing !== []) {
            throw new RuntimeException('Incomplete authorization schema. Restore or finish the existing schema before migrating.');
        }

        Schema::create('permission_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->foreignId('permission_category_id')->constrained()->restrictOnDelete();
            $table->timestamps();
        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['role_id', 'user_id']);
            $table->index('user_id');
        });
        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->primary(['permission_id', 'role_id']);
            $table->index('role_id');
        });
        Schema::create('permission_user', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['permission_id', 'user_id']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        foreach (['permission_user', 'permission_role', 'role_user', 'permissions', 'roles', 'permission_categories'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
