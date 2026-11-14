<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class HostelRoomType extends Model {
    use HasUuids;
    protected $fillable = ['name','capacity','description'];
    public function rooms() { return $this->hasMany(HostelRoom::class,'room_type_id'); }
}
