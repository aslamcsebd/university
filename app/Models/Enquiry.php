<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Enquiry extends Model {
    use HasUuids;
    protected $fillable = ['name','phone','email','program_id','source_id','assigned_to','follow_up_date','status','notes'];
    protected function casts(): array { return ['follow_up_date'=>'date']; }
    public function program() { return $this->belongsTo(Program::class); }
    public function source()  { return $this->belongsTo(EnquirySource::class,'source_id'); }
}
