<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class ContentType extends Model {
    use HasUuids;
    protected $fillable = ['name','icon'];
    public function contents() { return $this->hasMany(StudyContent::class,'content_type_id'); }
}
