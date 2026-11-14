<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class IncomeCategory extends Model {
    use HasUuids;
    protected $fillable = ['name','description'];
    public function incomes() { return $this->hasMany(Income::class,'category_id'); }
}
