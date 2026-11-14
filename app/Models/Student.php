<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Student extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id', 'student_id', 'first_name', 'last_name', 'gender',
        'dob', 'blood_group', 'religion', 'nationality', 'national_id',
        'phone', 'email', 'address', 'photo',
        'guardian_name', 'guardian_phone', 'guardian_email',
        'guardian_relation', 'guardian_address',
        'program_id', 'batch_id', 'current_semester_id',
        'admission_date', 'status', 'suspension_reason',
        'suspension_until', 'custom_fields',
    ];

    protected function casts(): array
    {
        return [
            'dob'             => 'date',
            'admission_date'  => 'date',
            'suspension_until'=> 'date',
            'custom_fields'   => 'array',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty()
            ->logExcept(['national_id', 'updated_at']);
    }

    public function user()            { return $this->belongsTo(User::class); }
    public function program()         { return $this->belongsTo(Program::class); }
    public function batch()           { return $this->belongsTo(Batch::class); }
    public function currentSemester() { return $this->belongsTo(Semester::class, 'current_semester_id'); }
    public function notes()           { return $this->hasMany(StudentNote::class); }
    public function statusHistory()   { return $this->hasMany(StudentStatusHistory::class)->latest(); }
    public function enrollments()     { return $this->hasMany(StudentEnrollment::class); }
    public function courseEnrollments() { return $this->hasMany(StudentCourseEnrollment::class); }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&background=7c3aed&color=fff';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active'      => 'bg-green-100 text-green-700',
            'graduated'   => 'bg-blue-100 text-blue-700',
            'suspended'   => 'bg-orange-100 text-orange-700',
            'dropped'     => 'bg-red-100 text-red-700',
            'transferred' => 'bg-purple-100 text-purple-700',
            'alumni'      => 'bg-indigo-100 text-indigo-700',
            default       => 'bg-gray-100 text-gray-600',
        };
    }

    public static function generateStudentId(Program $program): string
    {
        $prefix = strtoupper($program->short_name) . date('Y');
        $last   = static::withTrashed()
                        ->where('student_id', 'like', $prefix . '%')
                        ->orderByDesc('student_id')
                        ->first();
        $seq    = $last ? (intval(substr($last->student_id, -4)) + 1) : 1;
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    public function scopeActive($q)   { return $q->where('status', 'active'); }
}
