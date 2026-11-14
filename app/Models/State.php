<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class State extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['country_id', 'name'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
