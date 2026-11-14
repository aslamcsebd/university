<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class ItemStock extends Model {
    use HasUuids;
    protected $fillable = ['item_id','supplier_id','quantity','unit_cost','total_cost','purchase_date','invoice_no','received_by'];
    protected function casts(): array { return ['purchase_date'=>'date']; }
    public function item()     { return $this->belongsTo(Item::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
}
