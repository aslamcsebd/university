<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CustomFieldDefinition extends Model
{
    use HasUuids;

    protected $fillable = [
        'applies_to', 'label', 'field_name', 'field_type',
        'options', 'is_required', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'options'     => 'array',
            'is_required' => 'boolean',
            'is_active'   => 'boolean',
        ];
    }
}
