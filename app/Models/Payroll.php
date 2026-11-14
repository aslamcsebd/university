<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Payroll extends Model
{
    use HasUuids, LogsActivity;

    protected $fillable = [
        'staff_id', 'month', 'year', 'basic', 'gross',
        'allowances', 'deductions', 'tax', 'net_salary',
        'absent_days', 'working_days', 'status',
        'generated_by', 'approved_by', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'allowances' => 'array',
            'deductions' => 'array',
            'paid_at'    => 'date',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function staff()    { return $this->belongsTo(Staff::class); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }

    public function getMonthNameAttribute(): string
    {
        return date('F', mktime(0, 0, 0, $this->month, 1));
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'draft'    => 'bg-yellow-100 text-yellow-700',
            'approved' => 'bg-blue-100 text-blue-700',
            'paid'     => 'bg-green-100 text-green-700',
            default    => 'bg-gray-100 text-gray-600',
        };
    }
}
