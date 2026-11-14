<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Course extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'department_id', 'name', 'code', 'credit_hours', 'type', 'description', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active'    => 'boolean',
            'credit_hours' => 'decimal:2',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    { return LogOptions::defaults()->logAll()->logOnlyDirty(); }

    public function department()    { return $this->belongsTo(Department::class); }
    public function subjects()      { return $this->hasMany(Subject::class); }
    public function prerequisites() { return $this->belongsToMany(Course::class, 'course_prerequisites', 'course_id', 'prerequisite_id'); }
    public function sessionCourses(){ return $this->hasMany(SessionCourse::class); }

    public function getTypeLabelAttribute(): string
    {
        return ucfirst($this->type);
    }
}
