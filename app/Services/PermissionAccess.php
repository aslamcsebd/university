<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class PermissionAccess
{
    private ?array $known = null;

    private array $roles = [];

    private array $grants = [];

    public function reset(): void
    {
        $this->known = null;
        $this->roles = [];
        $this->grants = [];
    }

    public function knows(string $permission): bool
    {
        $this->known ??= array_fill_keys(Permission::pluck('name')->all(), true);

        return isset($this->known[$permission]);
    }

    public function roleNames(User $user): array
    {
        return $this->roles[$user->id] ??= $user->roles()->pluck('name')->all();
    }

    public function allows(User $user, string $permission): bool
    {
        if (! $this->knows($permission)) {
            return false;
        }
        if (in_array('super_admin', $this->roleNames($user), true)) {
            return true;
        }
        if (! isset($this->grants[$user->id])) {
            $keys = Permission::where(function (Builder $query) use ($user) {
                $query->whereHas('roles.users', fn (Builder $users) => $users->whereKey($user->id))
                    ->orWhereHas('users', fn (Builder $users) => $users->whereKey($user->id));
            })->pluck('name')->all();
            $this->grants[$user->id] = array_fill_keys($keys, true);
        }

        return isset($this->grants[$user->id][$permission]);
    }
}
