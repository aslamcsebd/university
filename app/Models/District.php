<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class District extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['state_id', 'name'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
