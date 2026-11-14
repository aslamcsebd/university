<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'session_course_id', 'title', 'description', 'due_date',
        'max_marks', 'attachment_path', 'is_published', 'created_by',
    ];

    protected $casts = ['due_date' => 'datetime', 'is_published' => 'boolean'];

    public function sessionCourse() { return $this->belongsTo(SessionCourse::class); }
    public function creator()       { return $this->belongsTo(User::class, 'created_by'); }
}
