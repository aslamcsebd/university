<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportAllocation extends Model
{
    protected $fillable = [
        'route_id', 'person_id', 'person_type', 'stop_id',
        'start_date', 'end_date', 'is_active',
    ];

    protected $casts = ['start_date' => 'date', 'end_date' => 'date', 'is_active' => 'boolean'];

    public function route()   { return $this->belongsTo(TransportRoute::class, 'route_id'); }
    public function stop()    { return $this->belongsTo(TransportStop::class, 'stop_id'); }
    public function student() { return $this->belongsTo(Student::class, 'person_id'); }
    public function staff()   { return $this->belongsTo(Staff::class, 'person_id'); }
}
