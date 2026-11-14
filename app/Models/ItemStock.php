<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model
{
    protected $fillable = [
        'item_id', 'supplier_id', 'quantity', 'unit_cost', 'total_cost',
        'purchase_date', 'invoice_no', 'received_by',
    ];

    protected $casts = ['purchase_date' => 'date'];

    public function item()     { return $this->belongsTo(Item::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function receiver() { return $this->belongsTo(User::class, 'received_by'); }
}
