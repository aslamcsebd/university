<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['plate_no', 'type', 'capacity', 'model', 'year', 'driver_id', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function driver() { return $this->belongsTo(Staff::class, 'driver_id'); }
    public function routes() { return $this->hasMany(TransportRoute::class); }
}
