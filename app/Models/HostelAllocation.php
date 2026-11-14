<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelAllocation extends Model
{
    protected $fillable = [
        'room_id', 'person_id', 'person_type',
        'move_in_date', 'move_out_date', 'status', 'notes',
    ];

    protected $casts = ['move_in_date' => 'date', 'move_out_date' => 'date'];

    public function room()    { return $this->belongsTo(HostelRoom::class, 'room_id'); }
    public function student() { return $this->belongsTo(Student::class, 'person_id'); }
    public function staff()   { return $this->belongsTo(Staff::class, 'person_id'); }
}
