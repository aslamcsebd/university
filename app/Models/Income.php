<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Income extends Model {
    use HasUuids;
    protected $fillable = ['category_id','title','amount','date','reference','notes','created_by'];
    protected function casts(): array { return ['date'=>'date']; }
    public function category()  { return $this->belongsTo(IncomeCategory::class,'category_id'); }
    public function creator()   { return $this->belongsTo(User::class,'created_by'); }
}
