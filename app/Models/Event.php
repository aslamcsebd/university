<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class Event extends Model {
    use HasUuids, SoftDeletes;
    protected $fillable = ['title','description','start_at','end_at','location','audience','is_published','created_by'];
    protected function casts(): array { return ['start_at'=>'datetime','end_at'=>'datetime','is_published'=>'boolean']; }
    public function creator() { return $this->belongsTo(User::class,'created_by'); }
}
