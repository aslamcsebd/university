<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class ScholarshipApplication extends Model {
    use HasUuids;
    protected $fillable = ['scholarship_id','student_id','semester_id','status','reviewed_by','reviewed_at','supporting_documents','notes'];
    protected function casts(): array { return ['reviewed_at'=>'datetime','supporting_documents'=>'array']; }
    public function scholarship() { return $this->belongsTo(Scholarship::class); }
    public function student()     { return $this->belongsTo(Student::class); }
    public function semester()    { return $this->belongsTo(Semester::class); }
    public function reviewer()    { return $this->belongsTo(User::class,'reviewed_by'); }
}
