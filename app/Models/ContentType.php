<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    protected $fillable = ['name', 'icon', 'description'];

    public function contents() { return $this->hasMany(StudyContent::class, 'content_type_id'); }
}
