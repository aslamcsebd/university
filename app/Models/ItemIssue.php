<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class ItemIssue extends Model {
    use HasUuids;
    protected $fillable = ['item_id','quantity','issued_to_id','issued_to_type','purpose','expected_return_date','issued_by','issued_at'];
    protected function casts(): array { return ['expected_return_date'=>'date','issued_at'=>'datetime']; }
    public function item() { return $this->belongsTo(Item::class); }
}
