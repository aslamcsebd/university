<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class Assignment extends Model {
    use HasUuids, SoftDeletes;
    protected $fillable = ['session_course_id','title','description','due_date','max_marks','attachment_path','is_published','created_by'];
    protected function casts(): array { return ['due_date'=>'date','is_published'=>'boolean']; }
    public function sessionCourse() { return $this->belongsTo(SessionCourse::class); }
    public function creator()       { return $this->belongsTo(User::class,'created_by'); }
}
