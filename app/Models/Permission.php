<?php

namespace App\Models;

use App\Services\PermissionAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = ['name', 'label', 'permission_category_id', 'permission_page_id', 'action', 'sort_order'];

    protected static function booted(): void
    {
        static::saved(fn () => app(PermissionAccess::class)->reset());
        static::deleted(fn () => app(PermissionAccess::class)->reset());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PermissionCategory::class, 'permission_category_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(PermissionPage::class, 'permission_page_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'permission_user');
    }
}
