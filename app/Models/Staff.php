<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Staff extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id', 'employee_id', 'first_name', 'last_name', 'gender',
        'dob', 'blood_group', 'religion', 'nationality', 'phone',
        'personal_email', 'address', 'photo', 'department_id',
        'designation_id', 'work_shift_id', 'employment_type', 'join_date',
        'contract_end_date', 'highest_degree', 'institution',
        'year_of_passing', 'specialization', 'experience_years',
        'is_teacher', 'is_active', 'custom_fields',
    ];

    protected function casts(): array
    {
        return [
            'dob'               => 'date',
            'join_date'         => 'date',
            'contract_end_date' => 'date',
            'is_teacher'        => 'boolean',
            'is_active'         => 'boolean',
            'custom_fields'     => 'array',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty()
            ->logExcept(['custom_fields', 'updated_at']);
    }

    public function user()        { return $this->belongsTo(User::class); }
    public function department()  { return $this->belongsTo(Department::class); }
    public function designation() { return $this->belongsTo(Designation::class); }
    public function workShift()   { return $this->belongsTo(WorkShift::class); }
    public function notes()       { return $this->hasMany(StaffNote::class); }
    public function leaveApplications() { return $this->hasMany(LeaveApplication::class, 'applicant_id', 'user_id'); }
    public function leaveBalances()     { return $this->hasMany(LeaveBalance::class); }
    public function salaryStructure()   { return $this->hasOne(SalaryStructure::class)->latest(); }
    public function payrolls()          { return $this->hasMany(Payroll::class); }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&background=1d4ed8&color=fff';
    }

    public static function generateEmployeeId(): string
    {
        $last = static::withTrashed()->orderByDesc('created_at')->first();
        $next = $last ? (intval(substr($last->employee_id, 3)) + 1) : 1;
        return 'EMP' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function scopeTeachers($q)  { return $q->where('is_teacher', true); }
    public function scopeActive($q)    { return $q->where('is_active', true); }
}
