<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ExamSchedule extends Model
{
    use HasUuids;
    protected $fillable = ['session_course_id', 'room_id', 'date', 'start_time', 'end_time', 'is_published'];
    protected function casts(): array { return ['date' => 'date', 'is_published' => 'boolean']; }
    public function sessionCourse() { return $this->belongsTo(SessionCourse::class); }
    public function room()          { return $this->belongsTo(Room::class); }
}
