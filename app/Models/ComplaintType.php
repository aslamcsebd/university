<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class ComplaintType extends Model {
    use HasUuids;
    protected $fillable = ['name'];
}
