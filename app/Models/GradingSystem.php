<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class GradingSystem extends Model
{
    use HasUuids;
    protected $fillable = ['name', 'description', 'max_gpa', 'is_default'];
    protected function casts(): array { return ['is_default' => 'boolean', 'max_gpa' => 'decimal:2']; }

    public function gradeRules()  { return $this->hasMany(GradeRule::class)->orderBy('sort_order'); }

    public function getGradeForPercentage(float $pct): ?GradeRule
    {
        return $this->gradeRules()
            ->where('min_percentage', '<=', $pct)
            ->where('max_percentage', '>=', $pct)
            ->first();
    }

    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->with('gradeRules')->first()
            ?? static::with('gradeRules')->first();
    }
}
