<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class Book extends Model {
    use HasUuids, SoftDeletes;
    protected $fillable = ['category_id','title','author','publisher','isbn','edition','quantity','available','shelf_no','cover_image','description'];
    public function category() { return $this->belongsTo(BookCategory::class,'category_id'); }
    public function issues()   { return $this->hasMany(BookIssue::class); }
}
