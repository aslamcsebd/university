<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Services\PermissionAccess;
use App\Support\PermissionCatalog;
use App\Support\PagePermissionRegistry;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(PermissionAccess::class);
        $this->app->scoped(PagePermissionRegistry::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Blade::if('access', fn (string $route) => PermissionCatalog::canVisit(auth()->user(), $route));
        Gate::before(function (User $user, string $ability) {
            // Policy abilities such as "update" are separate from permission keys.
            if (! str_contains($ability, '.')) {
                return null;
            }
            if (app(PermissionAccess::class)->knows($ability)) {
                return $user->hasPermissionTo($ability);
            }

            return null;
        });
    }
}
