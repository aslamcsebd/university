<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class Notice extends Model {
    use HasUuids, SoftDeletes;
    protected $fillable = ['category_id','title','content','audience','published_at','expires_at','is_pinned','attachments','created_by'];
    protected function casts(): array { return ['published_at'=>'datetime','expires_at'=>'datetime','is_pinned'=>'boolean','attachments'=>'array']; }
    public function category()  { return $this->belongsTo(NoticeCategory::class,'category_id'); }
    public function creator()   { return $this->belongsTo(User::class,'created_by'); }
    public function isActive(): bool { return $this->published_at && $this->published_at->isPast() && (!$this->expires_at || $this->expires_at->isFuture()); }
}
