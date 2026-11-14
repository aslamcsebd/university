<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class Vehicle extends Model {
    use HasUuids, SoftDeletes;
    protected $fillable = ['plate_no','type','capacity','model','year','driver_id','is_active'];
    protected function casts(): array { return ['is_active'=>'boolean']; }
    public function routes() { return $this->hasMany(TransportRoute::class); }
}
