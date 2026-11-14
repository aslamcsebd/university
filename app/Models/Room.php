<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Room extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'building_id', 'room_type_id', 'name', 'floor',
        'capacity', 'has_projector', 'has_ac', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'has_projector' => 'boolean',
            'has_ac'        => 'boolean',
            'is_active'     => 'boolean',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    { return LogOptions::defaults()->logAll()->logOnlyDirty(); }

    public function building()  { return $this->belongsTo(Building::class); }
    public function roomType()  { return $this->belongsTo(RoomType::class); }
}
