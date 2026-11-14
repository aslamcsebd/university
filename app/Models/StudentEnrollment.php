<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StudentEnrollment extends Model
{
    use HasUuids, LogsActivity;

    protected $fillable = [
        'student_id', 'section_id', 'semester_id',
        'enrolled_at', 'status', 'withdrawn_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'enrolled_at'  => 'date',
            'withdrawn_at' => 'date',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function student()  { return $this->belongsTo(Student::class); }
    public function section()  { return $this->belongsTo(Section::class); }
    public function semester() { return $this->belongsTo(Semester::class); }
}
