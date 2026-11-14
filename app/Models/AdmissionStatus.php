<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AdmissionStatus extends Model
{
    use HasUuids;
    protected $fillable = ['name', 'color', 'description', 'is_approval_trigger', 'order'];
    protected function casts(): array { return ['is_approval_trigger' => 'boolean']; }
    public function applications() { return $this->hasMany(AdmissionApplication::class, 'status_id'); }
}
