<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Supplier extends Model {
    use HasUuids;
    protected $fillable = ['name','contact_person','phone','email','address'];
    public function stocks() { return $this->hasMany(ItemStock::class); }
}
