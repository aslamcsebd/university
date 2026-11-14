<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class LibraryMember extends Model {
    use HasUuids;
    protected $fillable = ['person_id','person_type','member_no','valid_until','max_books','is_active'];
    protected function casts(): array { return ['is_active'=>'boolean','valid_until'=>'date']; }
    public function issues() { return $this->hasMany(BookIssue::class,'member_id'); }
    public function getActiveIssuesCountAttribute(): int { return $this->issues()->where('status','issued')->count(); }
    public function canBorrow(): bool { return $this->is_active && $this->active_issues_count < $this->max_books; }
    public static function generateMemberNo(string $type): string {
        $prefix = strtoupper(substr($type,0,3));
        $count  = static::where('person_type',$type)->count() + 1;
        return $prefix.str_pad($count,5,'0',STR_PAD_LEFT);
    }
}
