<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id', 'title', 'author', 'publisher', 'isbn',
        'edition', 'quantity', 'available', 'shelf_no', 'cover_image', 'description',
    ];

    public function category() { return $this->belongsTo(BookCategory::class, 'category_id'); }
    public function issues()   { return $this->hasMany(BookIssue::class); }
}
