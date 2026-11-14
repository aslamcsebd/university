<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudentStatusHistory extends Model
{
    use HasUuids;
    public $timestamps = false;
    protected $fillable = ['student_id', 'old_status', 'new_status', 'reason', 'changed_by', 'created_at'];
    protected function casts(): array { return ['created_at' => 'datetime']; }
    public function student()   { return $this->belongsTo(Student::class); }
    public function changedBy() { return $this->belongsTo(User::class, 'changed_by'); }
}
