<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Scholarship extends Model {
    use HasUuids;
    protected $fillable = ['name','type','description','value_type','value','eligibility_criteria','max_recipients','application_start','application_end','is_active'];
    protected function casts(): array { return ['is_active'=>'boolean','eligibility_criteria'=>'array','application_start'=>'date','application_end'=>'date']; }
    public function applications() { return $this->hasMany(ScholarshipApplication::class); }
}
