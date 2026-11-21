<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Support\PermissionCatalog;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class AccessManagement
{
    public function assignableRoles(User $actor): Collection
    {
        return Role::visibleTo($actor)->with('permissions')->orderBy('name')->get()
            ->filter(fn (Role $role) => $this->canAssign($actor, $role))->values();
    }

    public function canAssign(User $actor, Role $role): bool
    {
        if ($actor->isSuperAdmin()) {
            return true;
        }
        if (! $role->isVisibleTo($actor) || ! $actor->can('assign.roles') || $role->name === 'super_admin') {
            return false;
        }

        return $this->canGrant($actor, $role->permissions->pluck('name')->all());
    }

    public function canGrant(User $actor, array $permissions): bool
    {
        if ($actor->isSuperAdmin()) {
            return true;
        }
        if (collect($permissions)->contains(fn ($key) => PermissionCatalog::isPrivileged($key))) {
            return false;
        }

        return collect($permissions)->every(fn (string $permission) => $actor->can($permission));
    }

    public function validateRoles(User $actor, array $names): void
    {
        $roles = Role::with('permissions')->whereIn('name', $names)->get();
        if ($roles->count() !== count(array_unique($names)) || $roles->contains(fn (Role $role) => ! $this->canAssign($actor, $role))) {
            throw ValidationException::withMessages(['roles' => 'You cannot assign one or more selected roles.']);
        }
    }

    public function validatePermissions(User $actor, array $names): void
    {
        if (! $this->canGrant($actor, $names)) {
            throw ValidationException::withMessages(['permissions' => 'You may only grant permissions you hold; privileged permissions require a super administrator.']);
        }
    }

    public function validateDefaultRole(User $actor, string $name): void
    {
        $role = Role::where('name', $name)->firstOrFail();
        $this->validatePermissions($actor, $role->permissions()->pluck('name')->all());
    }

    public function protectAdministrator(User $user, array $roles, bool $active): void
    {
        if ($user->hasRole('super_admin') && (! $active || ! in_array('super_admin', $roles, true))) {
            $administrators = User::role('super_admin')->where('is_active', true)->lockForUpdate()->get();
            $other = $administrators->contains(fn (User $administrator) => $administrator->id !== $user->id);
            if (! $other) {
                throw ValidationException::withMessages(['roles' => 'The last active super administrator cannot be removed or deactivated.']);
            }
        }
    }
}
