<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudentCourseEnrollment extends Model
{
    use HasUuids;
    protected $fillable = ['student_id', 'session_course_id', 'enrolled_at', 'status'];
    protected function casts(): array { return ['enrolled_at' => 'date']; }
    public function student()       { return $this->belongsTo(Student::class); }
    public function sessionCourse() { return $this->belongsTo(SessionCourse::class); }
}
