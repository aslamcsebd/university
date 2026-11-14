<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudentNote extends Model
{
    use HasUuids;
    protected $fillable = ['student_id', 'note', 'created_by'];
    public function student() { return $this->belongsTo(Student::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
