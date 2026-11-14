<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ExamType extends Model
{
    use HasUuids;
    protected $fillable = ['semester_id', 'name', 'description'];
    public function semester()          { return $this->belongsTo(Semester::class); }
    public function markDistributions() { return $this->hasMany(MarkDistribution::class); }
}
