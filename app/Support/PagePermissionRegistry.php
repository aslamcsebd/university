<?php

namespace App\Support;

use App\Http\Middleware\AuthorizeModule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PagePermissionRegistry
{
    private array $signature = [];
    private array $compiled = [];

    public function catalog(): array
    {
        $pages = config('authorization.pages', []);
        $base = config('authorization.routes', []);
        $cards = config('authorization.dashboard_cards', []);
        $signature = [$pages, $base, $cards, config('authorization.permissions'), Route::getRoutes()->count()];
        if ($this->signature === $signature && $this->compiled) {
            return $this->compiled;
        }
        $routes = $base;
        $registeredRoutes = [];
        foreach (Route::getRoutes() as $route) {
            if ($route->getName() && in_array(AuthorizeModule::class, $route->gatherMiddleware(), true)) {
                $routes[$route->getName()] ??= null;
                $registeredRoutes[$route->getName()] = $route;
            }
        }
        $definitions = config('authorization.permissions', []);
        $crud = ['index' => 'view', 'show' => 'view', 'create' => 'create', 'store' => 'create', 'edit' => 'edit', 'update' => 'edit', 'destroy' => 'delete'];
        $privileged = ['manage.roles', 'manage.permissions', 'assign.roles', 'manage.settings', 'create.roles', 'edit.roles', 'delete.roles', 'duplicate.roles'];

        foreach ($routes as $name => $required) {
            if (in_array($name, config('authorization.personal_routes', []), true)) {
                continue;
            }
            $match = null;
            $length = -1;
            foreach ($pages as $key => $page) {
                foreach ($page['prefixes'] ?? [$key] as $prefix) {
                    if (($name === $prefix || str_starts_with($name, $prefix.'.')) && strlen($prefix) > $length) {
                        $match = [$key, $page, $prefix];
                        $length = strlen($prefix);
                    }
                }
            }
            if (! $match) {
                continue;
            }
            [$pageKey, $page, $pagePrefix] = $match;
            $route = $registeredRoutes[$name] ?? null;
            $suffix = Str::afterLast($name, '.');
            $legacy = $required[0] ?? null;
            $legacyAction = $legacy ? Str::before($legacy, '.') : null;
            $action = $page['actions'][$name] ?? null;
            if (! $action && ($page['keep_keys'] ?? false) && $legacy) {
                $action = $legacyAction;
            }
            if (! $action) {
                $action = $crud[$suffix] ?? null;
                if (! $action && $route && $name === $pagePrefix && in_array('GET', $route->methods(), true)) {
                    $action = 'view';
                }
                if ($legacy && $route && in_array('GET', $route->methods(), true) && ! in_array($suffix, ['create', 'edit'], true)) {
                    $action = 'view';
                } elseif ($legacy && ! in_array($legacyAction, ['view', 'create', 'edit', 'delete', 'manage'], true)) {
                    $action = $legacyAction;
                } elseif (! $action && $legacy) {
                    $action = $legacyAction === 'manage' ? Str::slug($suffix) : $legacyAction;
                }
            }
            // Unknown custom actions stay denied until explicitly mapped.
            if (! $action) {
                continue;
            }
            $key = ($page['keep_keys'] ?? false) && $legacy ? $legacy : $action.'.'.$pageKey;
            $definitions[$key] = array_merge($definitions[$key] ?? [], [
                'category' => $definitions[$key]['category'] ?? $page['category'],
                'label' => $definitions[$key]['label'] ?? Str::headline($action).' '.$page['label'],
                'page' => $pageKey,
                'action' => $action,
                'legacy' => $legacy,
                'privileged' => in_array($legacy, $privileged, true) || in_array($key, $privileged, true)
                    || in_array($page['category'], ['roles', 'permissions', 'settings'], true) || ($page['privileged'] ?? false),
            ]);
            $routes[$name] = array_values(array_unique([$key, ...array_slice($required ?? [], 1), ...($page['requires'][$action] ?? [])]));
        }

        foreach ($cards as $card => $definition) {
            $key = 'view.dashboard-'.$card;
            $definitions[$key] = [
                'category' => 'dashboard', 'page' => 'dashboard-cards', 'action' => 'view',
                'label' => $definition['label'], 'legacy' => $definition['requires'][0] ?? null,
            ];
        }
        $this->signature = $signature;

        return $this->compiled = ['pages' => $pages, 'permissions' => $definitions, 'routes' => $routes];
    }
}
