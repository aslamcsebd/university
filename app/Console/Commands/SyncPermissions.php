<?php

namespace App\Console\Commands;

use App\Support\PermissionCatalog;
use Illuminate\Console\Command;

class SyncPermissions extends Command
{
    protected $signature = 'permissions:sync';

    protected $description = 'Register the application permission catalog without changing existing role grants';

    public function handle(): int
    {
        PermissionCatalog::register();
        $this->info('Permission catalog synchronized. Existing roles, grants and labels were preserved.');

        return self::SUCCESS;
    }
}
