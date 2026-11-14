<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Department extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'faculty_id', 'name', 'short_name', 'code',
        'type', 'head_id', 'description', 'is_active',
    ];

    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function getActivitylogOptions(): LogOptions
    { return LogOptions::defaults()->logAll()->logOnlyDirty(); }

    public function faculty()     { return $this->belongsTo(Faculty::class); }
    public function programs()    { return $this->hasMany(Program::class); }
    public function courses()     { return $this->hasMany(Course::class); }

    public function scopeAcademic($q) { return $q->where('type', 'academic'); }
    public function scopeHr($q)       { return $q->where('type', 'hr'); }
}
