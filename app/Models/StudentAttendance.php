<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudentAttendance extends Model
{
    use HasUuids;
    protected $fillable = ['student_id', 'session_course_id', 'date', 'status', 'marked_by'];
    protected function casts(): array { return ['date' => 'date']; }
    public function student()       { return $this->belongsTo(Student::class); }
    public function sessionCourse() { return $this->belongsTo(SessionCourse::class); }
    public function markedBy()      { return $this->belongsTo(User::class, 'marked_by'); }
}
