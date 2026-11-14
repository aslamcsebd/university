<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FeeAssignment extends Model
{
    use HasUuids, LogsActivity;

    protected $fillable = [
        'student_id','fee_type_id','semester_id','amount',
        'discount_amount','fine_amount','net_amount','paid_amount',
        'due_date','status','notes',
    ];

    protected function casts(): array { return ['due_date' => 'date']; }

    public function getActivitylogOptions(): LogOptions
    { return LogOptions::defaults()->logAll()->logOnlyDirty(); }

    public function student()  { return $this->belongsTo(Student::class); }
    public function feeType()  { return $this->belongsTo(FeeType::class); }
    public function semester() { return $this->belongsTo(Semester::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    public function getOutstandingAttribute(): float
    {
        return max(0, $this->net_amount - $this->paid_amount);
    }

    public function recalculate(): void
    {
        $this->net_amount  = $this->amount - $this->discount_amount + $this->fine_amount;
        $this->paid_amount = $this->payments()->sum('amount');

        if ($this->paid_amount >= $this->net_amount) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'pending';
        }
        $this->save();
    }
}
