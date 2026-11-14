<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AdmissionApplication extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'program_id', 'academic_session_id', 'applicant_name', 'email',
        'phone', 'dob', 'address', 'documents', 'custom_fields',
        'status_id', 'reviewed_by', 'reviewed_at', 'remarks',
    ];

    protected function casts(): array
    {
        return [
            'dob'          => 'date',
            'reviewed_at'  => 'datetime',
            'documents'    => 'array',
            'custom_fields'=> 'array',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function program()         { return $this->belongsTo(Program::class); }
    public function academicSession() { return $this->belongsTo(AcademicSession::class); }
    public function status()          { return $this->belongsTo(AdmissionStatus::class, 'status_id'); }
    public function reviewer()        { return $this->belongsTo(User::class, 'reviewed_by'); }
    public function statusHistory()   { return $this->hasMany(AdmissionStatusHistory::class, 'application_id')->latest(); }

    public function convertToStudent(): Student
    {
        // Create user account
        $user = User::create([
            'name'              => $this->applicant_name,
            'email'             => $this->email,
            'password'          => bcrypt('Password@123'), // temp password
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $user->assignRole('student');

        // Generate student ID
        $studentId = Student::generateStudentId($this->program);

        // Create student
        $student = Student::create([
            'user_id'        => $user->id,
            'student_id'     => $studentId,
            'first_name'     => explode(' ', $this->applicant_name)[0],
            'last_name'      => implode(' ', array_slice(explode(' ', $this->applicant_name), 1)) ?: '-',
            'email'          => $this->email,
            'phone'          => $this->phone,
            'dob'            => $this->dob,
            'address'        => $this->address,
            'program_id'     => $this->program_id,
            'admission_date' => now(),
            'status'         => 'active',
        ]);

        return $student;
    }
}
