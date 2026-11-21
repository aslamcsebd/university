<?php

namespace App\Models\Concerns;

use App\Models\Permission;
use App\Models\Role;
use App\Services\PermissionAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Validation\ValidationException;

trait HasCustomPermissions
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_user');
    }

    public function getRoleNames(): SupportCollection
    {
        return collect(app(PermissionAccess::class)->roleNames($this));
    }

    public function hasRole(string $role): bool
    {
        return $this->getRoleNames()->contains($role);
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->getRoleNames()->intersect($roles)->isNotEmpty();
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_active && $this->hasRole('super_admin');
    }

    public function getAllPermissions(): Collection
    {
        return Permission::query()->where(function (Builder $query) {
            $query->whereHas('roles.users', fn (Builder $users) => $users->whereKey($this->getKey()))
                ->orWhereHas('users', fn (Builder $users) => $users->whereKey($this->getKey()));
        })->with('category')->orderBy('name')->get();
    }

    public function hasPermissionTo(string $permission): bool
    {
        if (! $this->is_active || $this->trashed() || $this->isLocked()) {
            return false;
        }

        return app(PermissionAccess::class)->allows($this, $permission);
    }

    public function assignRole(string $role): void
    {
        $this->syncRoles(array_values(array_unique([...$this->getRoleNames()->all(), $role])));
    }

    public function syncRoles(array $roles): void
    {
        $models = Role::whereIn('name', $roles)->get();
        if ($models->count() !== count(array_unique($roles))) {
            throw ValidationException::withMessages(['roles' => 'One or more roles do not exist.']);
        }
        $before = $this->getRoleNames()->all();
        $this->roles()->sync($models->modelKeys());
        $this->unsetRelation('roles');
        app(PermissionAccess::class)->reset();
        activity('authorization')->performedOn($this)->causedBy(auth()->user())
            ->withProperties(['before' => $before, 'after' => $roles])->log('User roles updated');
    }

    public function syncPermissions(array $permissions): void
    {
        $models = Permission::whereIn('name', $permissions)->get();
        if ($models->count() !== count(array_unique($permissions))) {
            throw ValidationException::withMessages(['permissions' => 'One or more permissions do not exist.']);
        }
        $before = $this->permissions()->pluck('name')->all();
        $this->permissions()->sync($models->modelKeys());
        $this->unsetRelation('permissions');
        app(PermissionAccess::class)->reset();
        activity('authorization')->performedOn($this)->causedBy(auth()->user())
            ->withProperties(['before' => $before, 'after' => $permissions])->log('User direct permissions updated');
    }

    public function scopeRole(Builder $query, string $role): Builder
    {
        return $query->whereHas('roles', fn (Builder $roles) => $roles->where('name', $role));
    }
}
