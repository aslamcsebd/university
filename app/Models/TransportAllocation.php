<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class TransportAllocation extends Model {
    use HasUuids;
    protected $fillable = ['route_id','person_id','person_type','stop_id','start_date','end_date','is_active'];
    protected function casts(): array { return ['is_active'=>'boolean','start_date'=>'date','end_date'=>'date']; }
    public function route() { return $this->belongsTo(TransportRoute::class,'route_id'); }
}
