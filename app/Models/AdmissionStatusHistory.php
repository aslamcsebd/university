<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AdmissionStatusHistory extends Model
{
    use HasUuids;
    protected $table = 'admission_status_history';
    public $timestamps = false;
    protected $fillable = ['application_id', 'status_id', 'changed_by', 'note', 'created_at'];
    protected function casts(): array { return ['created_at' => 'datetime']; }
    public function application() { return $this->belongsTo(AdmissionApplication::class); }
    public function status()      { return $this->belongsTo(AdmissionStatus::class); }
    public function changedBy()   { return $this->belongsTo(User::class, 'changed_by'); }
}
