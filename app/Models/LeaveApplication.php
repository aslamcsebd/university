<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LeaveApplication extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'applicant_id', 'applicant_type', 'leave_type_id',
        'from_date', 'to_date', 'days_count', 'reason', 'document',
        'status', 'reviewed_by', 'reviewed_at', 'review_notes',
    ];

    protected function casts(): array
    {
        return [
            'from_date'   => 'date',
            'to_date'     => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function applicant()  { return $this->belongsTo(User::class, 'applicant_id'); }
    public function leaveType()  { return $this->belongsTo(LeaveType::class); }
    public function reviewer()   { return $this->belongsTo(User::class, 'reviewed_by'); }
}
