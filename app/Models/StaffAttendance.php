<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StaffAttendance extends Model
{
    use HasUuids;
    protected $fillable = ['staff_id', 'date', 'check_in', 'check_out', 'status', 'notes'];
    protected function casts(): array { return ['date' => 'date']; }
    public function staff() { return $this->belongsTo(Staff::class); }
}
