<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Payment extends Model
{
    use HasUuids, LogsActivity;

    protected $fillable = [
        'student_id','fee_assignment_id','amount','payment_method',
        'transaction_ref','received_by','paid_at','receipt_no','gateway_response',
    ];

    protected function casts(): array
    { return ['paid_at' => 'datetime', 'gateway_response' => 'array']; }

    public function getActivitylogOptions(): LogOptions
    { return LogOptions::defaults()->logAll()->logOnlyDirty(); }

    public function student()       { return $this->belongsTo(Student::class); }
    public function feeAssignment() { return $this->belongsTo(FeeAssignment::class); }
    public function receivedBy()    { return $this->belongsTo(User::class, 'received_by'); }

    public static function generateReceiptNo(): string
    {
        $year = date('Y');
        $last = static::where('receipt_no', 'like', "RCP-{$year}-%")->orderByDesc('receipt_no')->first();
        $seq  = $last ? (intval(substr($last->receipt_no, -6)) + 1) : 1;
        return "RCP-{$year}-" . str_pad($seq, 6, '0', STR_PAD_LEFT);
    }
}
