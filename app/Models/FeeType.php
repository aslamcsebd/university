<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FeeType extends Model
{
    use HasUuids;
    protected $fillable = ['name', 'description', 'frequency', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
    public function assignments() { return $this->hasMany(FeeAssignment::class); }
}
