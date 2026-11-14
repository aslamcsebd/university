<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudentSemesterSummary extends Model
{
    use HasUuids;
    protected $fillable = [
        'student_id', 'semester_id', 'semester_gpa', 'cgpa',
        'total_credits_attempted', 'total_credits_earned', 'is_published',
    ];
    protected function casts(): array { return ['is_published' => 'boolean']; }
    public function student()  { return $this->belongsTo(Student::class); }
    public function semester() { return $this->belongsTo(Semester::class); }
}
