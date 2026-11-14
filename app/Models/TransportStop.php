<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportStop extends Model
{
    protected $fillable = ['route_id', 'name', 'order', 'pickup_time'];

    public function route() { return $this->belongsTo(TransportRoute::class, 'route_id'); }
}
