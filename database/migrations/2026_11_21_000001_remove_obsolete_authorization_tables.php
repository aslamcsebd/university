<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['permission_categories', 'roles', 'permissions', 'role_user', 'permission_role', 'permission_user'] as $table) {
            if (! Schema::hasTable($table)) {
                throw new RuntimeException('Custom authorization tables must exist before removing obsolete tables.');
            }
        }
        if (! Schema::hasColumns('permissions', ['label', 'permission_category_id']) || ! Schema::hasColumns('role_user', ['role_id', 'user_id'])) {
            throw new RuntimeException('Complete custom authorization setup before removing obsolete tables.');
        }

        // Drop only the explicitly obsolete tables, with their pivots first.
        $tables = array_values(array_filter([
            'model_has_permissions', 'model_has_roles', 'role_has_permissions',
            'legacy_model_has_permissions', 'legacy_model_has_roles', 'legacy_role_has_permissions',
            'legacy_permissions', 'legacy_roles',
        ], fn (string $table) => Schema::hasTable($table)));

        if ($tables !== []) {
            $backup = ['created_at' => now()->toIso8601String(), 'tables' => []];
            foreach ($tables as $table) {
                $backup['tables'][$table] = [
                    'columns' => Schema::getColumns($table),
                    'indexes' => Schema::getIndexes($table),
                    'foreign_keys' => Schema::getForeignKeys($table),
                    'rows' => DB::table($table)->get()->all(),
                ];
            }
            $path = 'authorization-backups/obsolete-tables-'.now()->format('Ymd-His').'-'.bin2hex(random_bytes(3)).'.json';
            if (! Storage::disk('local')->put($path, json_encode($backup, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR))) {
                throw new RuntimeException('Obsolete table backup failed; no tables were removed.');
            }
            foreach ($tables as $table) {
                Schema::drop($table);
            }
        }

        // Consolidate completed migration history so cleanup rollback does not
        // roll back the previously existing custom authorization schema.
        $oldCreation = '2026_11_14_064657_create_permission_tables';
        $oldConversion = '2026_11_21_000000_convert_to_custom_permissions';
        $customCreation = '2026_11_21_000000_create_custom_permission_tables';
        $originalBatch = DB::table('migrations')->where('migration', $oldConversion)->value('batch');
        if ($originalBatch !== null) {
            DB::table('migrations')->where('migration', $customCreation)->update(['batch' => $originalBatch]);
        }
        DB::table('migrations')->whereIn('migration', [$oldCreation, $oldConversion])->delete();
    }

    public function down(): void
    {
        // Obsolete schemas stay removed. Private JSON backups are retained;
        // rolling back this cleanup leaves current custom authorization intact.
    }
};
