<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermissionCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(PermissionPage::class)->orderBy('sort_order')->orderBy('id');
    }
}
