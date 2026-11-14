<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Semester extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'academic_session_id', 'name', 'term', 'start_date', 'end_date', 'is_current',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
            'is_current' => 'boolean',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    { return LogOptions::defaults()->logAll()->logOnlyDirty(); }

    public function academicSession()  { return $this->belongsTo(AcademicSession::class); }
    public function sections()         { return $this->hasMany(Section::class); }
    public function sessionCourses()   { return $this->hasMany(SessionCourse::class); }

    public function setCurrent(): void
    {
        static::where('academic_session_id', $this->academic_session_id)
              ->where('id', '!=', $this->id)
              ->update(['is_current' => false]);
        $this->update(['is_current' => true]);
    }

    public static function current(): ?self
    {
        return static::where('is_current', true)->first();
    }
}
