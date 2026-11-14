<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Country extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['name', 'code'];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
