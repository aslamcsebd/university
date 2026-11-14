<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LeaveType extends Model
{
    use HasUuids;
    protected $fillable = ['name', 'days_allowed', 'applies_to', 'is_paid', 'carry_forward', 'is_active'];
    protected function casts(): array
    {
        return ['is_paid' => 'boolean', 'carry_forward' => 'boolean', 'is_active' => 'boolean'];
    }
    public function applications() { return $this->hasMany(LeaveApplication::class); }
}
