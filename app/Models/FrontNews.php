<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class FrontNews extends Model {
    use HasUuids, SoftDeletes;
    protected $table = 'front_news';
    protected $fillable = ['title','slug','body','thumbnail','published_at','author_id','is_published'];
    protected function casts(): array { return ['published_at'=>'datetime','is_published'=>'boolean']; }
    public function author() { return $this->belongsTo(User::class,'author_id'); }
}
