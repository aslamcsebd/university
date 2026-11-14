<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemReturn extends Model
{
    protected $fillable = ['item_issue_id', 'quantity_returned', 'condition', 'returned_at', 'received_by'];

    protected $casts = ['returned_at' => 'datetime'];

    public function issue()    { return $this->belongsTo(ItemIssue::class, 'item_issue_id'); }
    public function receiver() { return $this->belongsTo(User::class, 'received_by'); }
}
