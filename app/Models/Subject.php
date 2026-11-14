<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Subject extends Model
{
    use HasUuids;

    protected $fillable = ['course_id', 'name', 'code', 'description'];

    public function course() { return $this->belongsTo(Course::class); }
}
