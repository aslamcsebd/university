<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class DocumentGeneration extends Model {
    use HasUuids;
    protected $fillable = ['student_id','document_type','semester_id','file_path','certificate_no','is_duplicate','generated_by','generated_at'];
    protected function casts(): array { return ['is_duplicate'=>'boolean','generated_at'=>'datetime']; }
    public function student()  { return $this->belongsTo(Student::class); }
    public function semester() { return $this->belongsTo(Semester::class); }
    public function generatedBy() { return $this->belongsTo(User::class,'generated_by'); }
}
