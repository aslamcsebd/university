<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SalaryStructure extends Model
{
    use HasUuids;
    protected $fillable = [
        'staff_id', 'basic_salary', 'house_allowance', 'transport_allowance',
        'medical_allowance', 'other_allowances', 'provident_fund_pct',
        'loan_deduction', 'effective_from',
    ];
    protected function casts(): array
    {
        return ['other_allowances' => 'array', 'effective_from' => 'date'];
    }
    public function staff() { return $this->belongsTo(Staff::class); }

    public function grossSalary(): float
    {
        return $this->basic_salary + $this->house_allowance
             + $this->transport_allowance + $this->medical_allowance;
    }
}
