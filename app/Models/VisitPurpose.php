<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class VisitPurpose extends Model {
    use HasUuids;
    protected $fillable = ['name'];
    public function visitors() { return $this->hasMany(VisitorLog::class,'purpose_id'); }
}
