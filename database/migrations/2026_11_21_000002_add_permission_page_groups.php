<?php

use App\Support\PermissionCatalog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('permission_pages')) {
            Schema::create('permission_pages', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->string('name');
                $table->foreignId('permission_category_id')->constrained()->restrictOnDelete();
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
        if (! Schema::hasColumn('permissions', 'permission_page_id')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->foreignId('permission_page_id')->nullable()->constrained()->nullOnDelete();
                $table->string('action')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
            });
        }

        // This is the only upgrade that copies old grants to the new page keys.
        // Normal catalog synchronization never assigns permissions.
        DB::transaction(function () {
            PermissionCatalog::register();
            $ids = DB::table('permissions')->pluck('id', 'name');
            foreach (PermissionCatalog::definitions() as $key => $definition) {
                $legacy = $definition['legacy'] ?? null;
                if (! $legacy || $legacy === $key || ! isset($ids[$legacy])) {
                    continue;
                }
                foreach (['permission_role' => 'role_id', 'permission_user' => 'user_id'] as $table => $owner) {
                    $rows = DB::table($table)->where('permission_id', $ids[$legacy])->pluck($owner)
                        ->map(fn ($id) => [$owner => $id, 'permission_id' => $ids[$key]])->all();
                    foreach (array_chunk($rows, 500) as $chunk) {
                        DB::table($table)->insertOrIgnore($chunk);
                    }
                }
            }
        });
    }

    public function down(): void
    {
        // Granular grants cannot safely be collapsed back into broader grants.
        // Preserve data; restore the private backup with the previous app if needed.
    }
};
