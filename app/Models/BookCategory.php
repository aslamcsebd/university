<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class BookCategory extends Model {
    use HasUuids;
    protected $fillable = ['name','description'];
    public function books() { return $this->hasMany(Book::class,'category_id'); }
}
