<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class WorkShift extends Model
{
    use HasUuids;
    protected $fillable = ['name', 'start_time', 'end_time', 'grace_minutes', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
    public function staff() { return $this->hasMany(Staff::class); }
}
