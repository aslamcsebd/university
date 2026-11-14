<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'category_id', 'store_id', 'name', 'code', 'unit',
        'quantity', 'min_threshold', 'is_consumable', 'description',
    ];

    protected $casts = ['is_consumable' => 'boolean'];

    public function category() { return $this->belongsTo(ItemCategory::class, 'category_id'); }
    public function store()    { return $this->belongsTo(Store::class); }
    public function stocks()   { return $this->hasMany(ItemStock::class); }
    public function issues()   { return $this->hasMany(ItemIssue::class); }

    public function isLowStock(): bool
    {
        return $this->min_threshold > 0 && $this->quantity <= $this->min_threshold;
    }
}
