<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudentResult extends Model
{
    use HasUuids;
    protected $fillable = [
        'student_id', 'semester_id', 'session_course_id',
        'total_marks', 'obtained_marks', 'percentage',
        'letter_grade', 'grade_rule_id', 'gpa_point', 'credit_hours',
        'is_pass', 'is_published', 'published_at', 'published_by',
    ];
    protected function casts(): array
    {
        return ['is_pass' => 'boolean', 'is_published' => 'boolean', 'published_at' => 'datetime'];
    }
    public function student()       { return $this->belongsTo(Student::class); }
    public function semester()      { return $this->belongsTo(Semester::class); }
    public function sessionCourse() { return $this->belongsTo(SessionCourse::class); }
    public function gradeRule()     { return $this->belongsTo(GradeRule::class); }
}
