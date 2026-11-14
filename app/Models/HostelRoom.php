<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class HostelRoom extends Model {
    use HasUuids;
    protected $fillable = ['hostel_id','room_type_id','room_number','floor','capacity','current_occupants','is_available'];
    protected function casts(): array { return ['is_available'=>'boolean']; }
    public function hostel()   { return $this->belongsTo(Hostel::class); }
    public function roomType() { return $this->belongsTo(HostelRoomType::class,'room_type_id'); }
    public function allocations() { return $this->hasMany(HostelAllocation::class,'room_id'); }
}
