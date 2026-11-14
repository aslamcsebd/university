<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Building extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = ['campus_id', 'name', 'floors', 'description', 'is_active'];

    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function getActivitylogOptions(): LogOptions
    { return LogOptions::defaults()->logAll()->logOnlyDirty(); }

    public function campus() { return $this->belongsTo(Campus::class); }
    public function rooms()  { return $this->hasMany(Room::class); }
}
