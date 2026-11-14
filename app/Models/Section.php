<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = ['batch_id', 'semester_id', 'name', 'capacity'];

    public function batch()    { return $this->belongsTo(Batch::class); }
    public function semester() { return $this->belongsTo(Semester::class); }
}
