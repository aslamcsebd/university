<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name', 'location', 'incharge_id', 'description'];

    public function incharge() { return $this->belongsTo(Staff::class, 'incharge_id'); }
    public function items()    { return $this->hasMany(Item::class); }
}
