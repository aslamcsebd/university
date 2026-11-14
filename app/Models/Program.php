<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Program extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'department_id', 'name', 'short_name', 'code',
        'level', 'duration_years', 'total_credits', 'description', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active'      => 'boolean',
            'duration_years' => 'decimal:1',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    { return LogOptions::defaults()->logAll()->logOnlyDirty(); }

    public function department() { return $this->belongsTo(Department::class); }
    public function batches()    { return $this->hasMany(Batch::class); }

    public function getLevelLabelAttribute(): string
    {
        return ucfirst($this->level);
    }
}
