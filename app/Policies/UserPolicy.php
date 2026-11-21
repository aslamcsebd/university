<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessManagement;

class UserPolicy
{
    public function view(User $actor, User $target): bool
    {
        return $actor->can('view.users') && $target->isVisibleTo($actor);
    }

    public function update(User $actor, User $target): bool
    {
        return $actor->can('edit.users') && $this->canManage($actor, $target);
    }

    public function delete(User $actor, User $target): bool
    {
        return $actor->can('delete.users') && $actor->id !== $target->id
            && $this->canManage($actor, $target);
    }

    private function canManage(User $actor, User $target): bool
    {
        if (! $target->isVisibleTo($actor)) {
            return false;
        }
        if ($actor->isSuperAdmin()) {
            return true;
        }
        if ($target->hasRole('super_admin')) {
            return false;
        }

        return $actor->id === $target->id
            || app(AccessManagement::class)->canGrant($actor, $target->getAllPermissions()->pluck('name')->all());
    }
}
