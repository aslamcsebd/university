<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $fillable = ['campus_id', 'name', 'type', 'warden_id', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function campus()  { return $this->belongsTo(Campus::class); }
    public function warden()  { return $this->belongsTo(Staff::class, 'warden_id'); }
    public function rooms()   { return $this->hasMany(HostelRoom::class); }
}
