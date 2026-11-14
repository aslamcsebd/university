<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LeaveBalance extends Model
{
    use HasUuids;
    protected $fillable = ['staff_id', 'leave_type_id', 'year', 'entitlement', 'used', 'balance'];
    public function staff()     { return $this->belongsTo(Staff::class); }
    public function leaveType() { return $this->belongsTo(LeaveType::class); }
}
