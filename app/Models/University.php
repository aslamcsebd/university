<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class University extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'short_name', 'tagline', 'logo', 'favicon',
        'address', 'phone', 'email', 'website',
        'established_at', 'timezone', 'currency', 'currency_symbol',
    ];

    protected function casts(): array
    {
        return [
            'established_at' => 'date',
        ];
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/default-logo.png');
    }

    public static function current(): ?self
    {
        return static::first();
    }
}
