<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookIssue extends Model
{
    protected $fillable = [
        'book_id', 'member_id', 'issued_by', 'issue_date', 'due_date',
        'return_date', 'fine_amount', 'fine_paid', 'status',
    ];

    protected $casts = [
        'issue_date'  => 'date',
        'due_date'    => 'date',
        'return_date' => 'date',
        'fine_paid'   => 'boolean',
    ];

    public function book()   { return $this->belongsTo(Book::class); }
    public function member() { return $this->belongsTo(LibraryMember::class, 'member_id'); }
    public function issuer() { return $this->belongsTo(User::class, 'issued_by'); }
}
