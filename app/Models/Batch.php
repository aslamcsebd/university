<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Batch extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'program_id', 'academic_session_id', 'name',
        'intake_year', 'max_students', 'is_active',
    ];

    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function getActivitylogOptions(): LogOptions
    { return LogOptions::defaults()->logAll()->logOnlyDirty(); }

    public function program()         { return $this->belongsTo(Program::class); }
    public function academicSession() { return $this->belongsTo(AcademicSession::class); }
    public function sections()        { return $this->hasMany(Section::class); }
}
