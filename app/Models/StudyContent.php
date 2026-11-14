<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyContent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'session_course_id', 'content_type_id', 'title', 'description',
        'file_path', 'file_size', 'uploaded_by', 'is_published',
    ];

    protected $casts = ['is_published' => 'boolean'];

    public function sessionCourse() { return $this->belongsTo(SessionCourse::class); }
    public function contentType()   { return $this->belongsTo(ContentType::class, 'content_type_id'); }
    public function uploader()      { return $this->belongsTo(User::class, 'uploaded_by'); }
}
