<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ClassSchedule extends Model
{
    use HasUuids;
    protected $fillable = ['session_course_id', 'day_of_week', 'start_time', 'end_time', 'room_id', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function sessionCourse() { return $this->belongsTo(SessionCourse::class); }
    public function room()          { return $this->belongsTo(Room::class); }

    public function getDayNameAttribute(): string
    {
        return ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][$this->day_of_week] ?? '—';
    }

    public function hasConflict(): array
    {
        $conflicts = [];
        $existing = static::where('id', '!=', $this->id)
            ->where('day_of_week', $this->day_of_week)
            ->where('is_active', true)
            ->whereHas('sessionCourse', fn($q) => $q->where('semester_id', $this->sessionCourse->semester_id))
            ->where(fn($q) => $q->where('start_time', '<', $this->end_time)->where('end_time', '>', $this->start_time))
            ->with('sessionCourse.section')
            ->get();

        foreach ($existing as $e) {
            if ($e->room_id && $e->room_id === $this->room_id) {
                $conflicts[] = "Room conflict with {$e->sessionCourse->course->code}";
            }
            if ($e->sessionCourse->teacher_id && $e->sessionCourse->teacher_id === $this->sessionCourse->teacher_id) {
                $conflicts[] = "Teacher conflict with {$e->sessionCourse->course->code}";
            }
            if ($e->sessionCourse->section_id && $e->sessionCourse->section_id === $this->sessionCourse->section_id) {
                $conflicts[] = "Section conflict with {$e->sessionCourse->course->code}";
            }
        }
        return $conflicts;
    }
}
