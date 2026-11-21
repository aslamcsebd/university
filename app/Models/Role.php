<?php

namespace App\Models;

use App\Models\Concerns\RecordsCreator;
use App\Services\PermissionAccess;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Validation\ValidationException;

class Role extends Model
{
    use RecordsCreator;

    protected $fillable = ['name', 'label', 'description'];

    protected static function booted(): void
    {
        static::created(function (Role $role) {
            activity('authorization')->event('created')->performedOn($role)->causedBy(auth()->user())
                ->withProperties(['created_by' => $role->created_by])->log('Role created');
        });
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function isSystem(): bool
    {
        return in_array($this->name, ['super_admin', 'teacher', 'student'], true);
    }

    public function syncPermissions(array|Collection $permissions): void
    {
        $ids = $permissions instanceof Collection
            ? $permissions->modelKeys()
            : Permission::whereIn('name', $permissions)->pluck('id')->all();

        if (count($ids) !== count($permissions instanceof Collection ? $permissions->modelKeys() : array_unique($permissions))) {
            throw ValidationException::withMessages(['permissions' => 'One or more permissions do not exist.']);
        }

        $before = $this->permissions()->pluck('name')->all();
        $this->permissions()->sync($ids);
        $this->unsetRelation('permissions');
        app(PermissionAccess::class)->reset();

        activity('authorization')->performedOn($this)->causedBy(auth()->user())
            ->withProperties(['before' => $before, 'after' => $this->permissions()->pluck('name')->all()])
            ->log('Role permissions updated');
    }
}
