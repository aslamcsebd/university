<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Slider extends Model {
    use HasUuids;
    protected $fillable = ['title','subtitle','image','cta_text','cta_link','order','is_active'];
    protected function casts(): array { return ['is_active'=>'boolean']; }
}
