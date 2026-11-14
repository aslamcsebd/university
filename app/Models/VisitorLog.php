<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class VisitorLog extends Model {
    use HasUuids;
    protected $fillable = ['name','phone','id_number','purpose_id','host_id','check_in','check_out','badge_no','notes'];
    protected function casts(): array { return ['check_in'=>'datetime','check_out'=>'datetime']; }
    public function purpose() { return $this->belongsTo(VisitPurpose::class,'purpose_id'); }
}
