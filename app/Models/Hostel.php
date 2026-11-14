<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class Hostel extends Model {
    use HasUuids, SoftDeletes;
    protected $fillable = ['campus_id','name','type','warden_id','description'];
    public function campus() { return $this->belongsTo(Campus::class); }
    public function rooms()  { return $this->hasMany(HostelRoom::class); }
}
