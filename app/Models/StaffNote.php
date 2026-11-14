<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StaffNote extends Model
{
    use HasUuids;
    protected $fillable = ['staff_id', 'note', 'created_by'];
    public function staff()   { return $this->belongsTo(Staff::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
