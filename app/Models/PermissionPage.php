<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermissionPage extends Model
{
    protected $fillable = ['key', 'name', 'permission_category_id', 'sort_order'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PermissionCategory::class, 'permission_category_id');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }
}
