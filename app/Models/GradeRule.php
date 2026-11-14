<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class GradeRule extends Model
{
    use HasUuids;
    protected $fillable = ['grading_system_id', 'letter_grade', 'min_percentage', 'max_percentage', 'gpa_point', 'is_pass', 'sort_order'];
    protected function casts(): array { return ['is_pass' => 'boolean']; }
    public function gradingSystem() { return $this->belongsTo(GradingSystem::class); }
}
