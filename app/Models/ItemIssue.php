<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemIssue extends Model
{
    protected $fillable = [
        'item_id', 'quantity', 'issued_to_id', 'issued_to_type',
        'purpose', 'expected_return_date', 'issued_by', 'issued_at',
    ];

    protected $casts = ['expected_return_date' => 'date', 'issued_at' => 'datetime'];

    public function item()    { return $this->belongsTo(Item::class); }
    public function issuer()  { return $this->belongsTo(User::class, 'issued_by'); }
    public function returns() { return $this->hasMany(ItemReturn::class, 'item_issue_id'); }
}
