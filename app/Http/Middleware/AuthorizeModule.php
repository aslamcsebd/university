<?php

namespace App\Http\Middleware;

use App\Services\PermissionAccess;
use App\Support\PermissionCatalog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeModule
{
    public function handle(Request $request, Closure $next): Response
    {
        app(PermissionAccess::class)->reset();
        abort_unless($request->user()?->is_active && ! $request->user()->isLocked(), 403, 'Your account is inactive or locked.');

        $permissions = PermissionCatalog::forRoute($request->route()?->getName());
        abort_if($permissions === null, 403, 'This action has no registered access rule.');

        foreach ($permissions as $permission) {
            abort_unless($request->user()->can($permission), 403, 'You do not have permission for this action.');
        }

        return $next($request);
    }
}
