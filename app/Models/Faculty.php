<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Faculty extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = ['name', 'short_name', 'code', 'dean_id', 'description', 'logo', 'is_active'];

    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function getActivitylogOptions(): LogOptions
    { return LogOptions::defaults()->logAll()->logOnlyDirty(); }

    public function departments()     { return $this->hasMany(Department::class); }
    public function programs()        { return $this->hasManyThrough(Program::class, Department::class); }
    public function activeDepartments() { return $this->hasMany(Department::class)->where('is_active', true); }
}
