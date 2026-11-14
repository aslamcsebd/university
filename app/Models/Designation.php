<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Designation extends Model
{
    use HasUuids;
    protected $fillable = ['name', 'description', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
    public function staff() { return $this->hasMany(Staff::class); }
}
