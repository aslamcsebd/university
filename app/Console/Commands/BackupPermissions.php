<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class BackupPermissions extends Command
{
    protected $signature = 'permissions:backup';

    protected $description = 'Save a private JSON backup of role and permission tables';

    public function handle(): int
    {
        $tables = ['roles', 'permissions', 'permission_categories', 'permission_pages', 'role_user', 'permission_role', 'permission_user'];
        $backup = ['created_at' => now()->toIso8601String(), 'tables' => []];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $backup['tables'][$table] = DB::table($table)->get()->all();
            }
        }
        if (Schema::hasColumn('users', 'created_by')) {
            $backup['ownership']['users'] = DB::table('users')->select('id', 'created_by')->get()->all();
        }
        $path = 'authorization-backups/permissions-'.now()->format('Ymd-His').'-'.bin2hex(random_bytes(3)).'.json';
        if (! Storage::disk('local')->put($path, json_encode($backup, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR))) {
            $this->error('Permission backup could not be written. No success was recorded.');

            return self::FAILURE;
        }
        $this->info('Permission backup saved: '.Storage::disk('local')->path($path));

        return self::SUCCESS;
    }
}
