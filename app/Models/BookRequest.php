<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    protected $fillable = ['member_id', 'book_title', 'author', 'reason', 'status'];

    public function member() { return $this->belongsTo(LibraryMember::class, 'member_id'); }
}
