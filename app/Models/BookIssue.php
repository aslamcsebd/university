<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class BookIssue extends Model {
    use HasUuids;
    protected $fillable = ['book_id','member_id','issued_by','issue_date','due_date','return_date','fine_amount','fine_paid','status'];
    protected function casts(): array { return ['issue_date'=>'date','due_date'=>'date','return_date'=>'date','fine_paid'=>'boolean']; }
    public function book()   { return $this->belongsTo(Book::class); }
    public function member() { return $this->belongsTo(LibraryMember::class,'member_id'); }
    public function calculateFine(float $ratePerDay = 2.0): float {
        if (!$this->return_date || $this->return_date <= $this->due_date) return 0;
        return $this->return_date->diffInDays($this->due_date) * $ratePerDay;
    }
}
