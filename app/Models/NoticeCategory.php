<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class NoticeCategory extends Model {
    use HasUuids;
    protected $fillable = ['name','color'];
    public function notices() { return $this->hasMany(Notice::class,'category_id'); }
}
