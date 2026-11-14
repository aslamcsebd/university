<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TaxSetting extends Model
{
    use HasUuids;
    protected $fillable = ['name', 'slabs', 'is_default'];
    protected function casts(): array
    {
        return ['slabs' => 'array', 'is_default' => 'boolean'];
    }
    public function calculateMonthlyTax(float $grossMonthly): float
    {
        $annualGross = $grossMonthly * 12;
        $annualTax   = 0;
        foreach ($this->slabs as $slab) {
            $min  = $slab['min'] ?? 0;
            $max  = $slab['max'] ?? PHP_INT_MAX;
            $rate = ($slab['rate'] ?? 0) / 100;
            if ($annualGross > $min) {
                $taxable    = min($annualGross, $max) - $min;
                $annualTax += $taxable * $rate;
            }
        }
        return round($annualTax / 12, 2);
    }
}
