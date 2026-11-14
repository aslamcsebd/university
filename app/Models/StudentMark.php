<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudentMark extends Model
{
    use HasUuids;
    protected $fillable = ['student_id', 'mark_distribution_id', 'marks_obtained', 'is_absent', 'entered_by'];
    protected function casts(): array { return ['is_absent' => 'boolean']; }
    public function student()          { return $this->belongsTo(Student::class); }
    public function markDistribution() { return $this->belongsTo(MarkDistribution::class); }
}
