<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class HostelAllocation extends Model {
    use HasUuids;
    protected $fillable = ['room_id','person_id','person_type','move_in_date','move_out_date','status','notes'];
    protected function casts(): array { return ['move_in_date'=>'date','move_out_date'=>'date']; }
    public function room() { return $this->belongsTo(HostelRoom::class,'room_id'); }
}
