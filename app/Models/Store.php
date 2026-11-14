<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Store extends Model {
    use HasUuids;
    protected $fillable = ['name','location','incharge_id','description'];
    public function items() { return $this->hasMany(Item::class); }
}
