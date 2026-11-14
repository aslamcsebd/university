<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MarkDistribution extends Model
{
    use HasUuids;
    protected $fillable = ['session_course_id', 'exam_type_id', 'total_marks', 'pass_marks', 'weightage'];
    public function sessionCourse() { return $this->belongsTo(SessionCourse::class); }
    public function examType()      { return $this->belongsTo(ExamType::class); }
    public function studentMarks()  { return $this->hasMany(StudentMark::class); }
}
