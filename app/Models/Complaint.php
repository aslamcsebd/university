<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Complaint extends Model {
    use HasUuids;
    protected $fillable = ['complainant_name','phone','type_id','assigned_to','description','status','resolution_notes'];
    public function type() { return $this->belongsTo(ComplaintType::class,'type_id'); }
}
