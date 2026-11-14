<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Item extends Model {
    use HasUuids;
    protected $fillable = ['category_id','store_id','name','code','unit','quantity','min_threshold','is_consumable','description'];
    protected function casts(): array { return ['is_consumable'=>'boolean']; }
    public function category()  { return $this->belongsTo(ItemCategory::class,'category_id'); }
    public function store()     { return $this->belongsTo(Store::class); }
    public function stocks()    { return $this->hasMany(ItemStock::class); }
    public function issues()    { return $this->hasMany(ItemIssue::class); }
    public function isLowStock(): bool { return $this->quantity <= $this->min_threshold; }
}
