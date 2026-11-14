<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class TransportRoute extends Model {
    use HasUuids;
    protected $fillable = ['vehicle_id','name','from_location','to_location','fare','is_active'];
    protected function casts(): array { return ['is_active'=>'boolean']; }
    public function vehicle()     { return $this->belongsTo(Vehicle::class); }
    public function stops()       { return $this->hasMany(TransportStop::class,'route_id')->orderBy('order'); }
    public function allocations() { return $this->hasMany(TransportAllocation::class,'route_id'); }
}
