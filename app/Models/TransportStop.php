<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class TransportStop extends Model {
    use HasUuids;
    protected $fillable = ['route_id','name','order','pickup_time'];
    public function route() { return $this->belongsTo(TransportRoute::class,'route_id'); }
}
