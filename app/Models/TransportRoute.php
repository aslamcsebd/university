<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportRoute extends Model
{
    protected $fillable = ['vehicle_id', 'name', 'from_location', 'to_location', 'fare', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function vehicle()     { return $this->belongsTo(Vehicle::class); }
    public function stops()       { return $this->hasMany(TransportStop::class, 'route_id')->orderBy('order'); }
    public function allocations() { return $this->hasMany(TransportAllocation::class, 'route_id'); }
}
