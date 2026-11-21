<?php

namespace App\Support;

use App\Models\Permission;
use App\Models\PermissionCategory;
use App\Models\PermissionPage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PermissionCatalog
{
    public static function forRoute(?string $route): ?array
    {
        return app(PagePermissionRegistry::class)->catalog()['routes'][$route] ?? null;
    }

    public static function canVisit(?User $user, string $route): bool
    {
        $required = self::forRoute($route);

        return $user && $user->is_active && $required !== null
            && collect($required)->every(fn (string $permission) => $user->can($permission));
    }

    public static function register(): void
    {
        DB::transaction(function () {
            foreach (config('authorization.categories') as $slug => $name) {
                PermissionCategory::firstOrCreate(['slug' => $slug], ['name' => $name]);
            }
            $categories = PermissionCategory::pluck('id', 'slug');
            $pages = [];
            $orders = [];
            foreach (config('authorization.pages', []) as $key => $definition) {
                $category = $definition['category'];
                $order = $orders[$category] = ($orders[$category] ?? 0) + 1;
                $page = PermissionPage::firstOrCreate(['key' => $key], [
                    'name' => $definition['label'], 'permission_category_id' => $categories[$category], 'sort_order' => $order,
                ]);
                $page->update(['sort_order' => $order]);
                $pages[$key] = $page;
            }
            $actionOrder = ['view', 'create', 'edit', 'delete', 'assign', 'approve', 'publish', 'export', 'manage'];
            foreach (self::definitions() as $key => $definition) {
                $permission = Permission::firstOrCreate(['name' => $key], [
                    'label' => $definition['label'], 'permission_category_id' => $categories[$definition['category']],
                ]);
                $page = $pages[$definition['page'] ?? ''] ?? null;
                $action = $definition['action'] ?? Str::before($key, '.');
                $permission->update([
                    'permission_page_id' => $page && (int) $page->permission_category_id === (int) $permission->permission_category_id ? $page->id : null,
                    'action' => $action,
                    'sort_order' => ($position = array_search($action, $actionOrder, true)) !== false ? $position : 100,
                ]);
            }
        });
    }

    public static function definitions(): array
    {
        return app(PagePermissionRegistry::class)->catalog()['permissions'];
    }

    public static function activeKeys(): array
    {
        $keys = [];
        foreach (Route::getRoutes() as $route) {
            if (in_array(\App\Http\Middleware\AuthorizeModule::class, $route->gatherMiddleware(), true)) {
                $keys = [...$keys, ...(self::forRoute($route->getName()) ?? [])];
            }
        }
        foreach (config('authorization.dashboard_cards', []) as $card => $definition) {
            $keys = [...$keys, 'view.dashboard-'.$card, ...($definition['requires'] ?? [])];
        }

        return array_values(array_unique($keys));
    }

    public static function isPrivileged(string $key): bool
    {
        return self::definitions()[$key]['privileged'] ?? in_array($key, ['manage.roles', 'manage.permissions', 'assign.roles', 'manage.settings'], true);
    }

    // Used only for initial default roles, never when saving/synchronizing grants.
    public static function initialGrants(array $keys): array
    {
        $original = array_fill_keys($keys, true);
        foreach (self::definitions() as $key => $definition) {
            if (isset($original[$definition['legacy'] ?? ''])) {
                $keys[] = $key;
            }
        }

        return array_values(array_unique($keys));
    }

    public static function canSeeDashboardCard(?User $user, string $card): bool
    {
        $definition = config('authorization.dashboard_cards')[$card] ?? null;

        return $definition !== null && $user?->is_active && ! $user->isLocked()
            && $user->can('view.dashboard-'.$card)
            && collect($definition['requires'])->every(fn ($key) => $user->can($key));
    }
}
