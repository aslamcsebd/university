<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Services\AccessManagement;

class RolePolicy
{
    public function view(User $actor, Role $role): bool
    {
        return $actor->can('view.roles') && $role->isVisibleTo($actor);
    }

    public function update(User $actor, Role $role): bool
    {
        return $role->isVisibleTo($actor) && $role->name !== 'super_admin' && $actor->can('edit.roles')
            && app(AccessManagement::class)->canGrant($actor, $role->permissions()->pluck('name')->all());
    }

    public function delete(User $actor, Role $role): bool
    {
        return $role->isVisibleTo($actor) && ! $role->isSystem() && $actor->can('delete.roles') && ! $role->users()->withTrashed()->exists()
            && app(AccessManagement::class)->canGrant($actor, $role->permissions()->pluck('name')->all());
    }

    public function duplicate(User $actor, Role $role): bool
    {
        return $role->isVisibleTo($actor) && $role->name !== 'super_admin' && $actor->can('duplicate.roles')
            && app(AccessManagement::class)->canGrant($actor, $role->permissions()->pluck('name')->all());
    }
}
