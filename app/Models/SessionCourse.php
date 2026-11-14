<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SessionCourse extends Model
{
    use HasUuids;

    protected $fillable = ['semester_id', 'course_id', 'section_id', 'teacher_id', 'room_id'];

    public function semester() { return $this->belongsTo(Semester::class); }
    public function course()   { return $this->belongsTo(Course::class); }
    public function section()  { return $this->belongsTo(Section::class); }
    public function room()     { return $this->belongsTo(Room::class); }
}
