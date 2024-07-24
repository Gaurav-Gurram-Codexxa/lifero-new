<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class billPayment extends Model
{
    use HasFactory;

    public $table = 'bill_payments';

    public $fillable = [
        'bill_id',
        'patient_id',
        'paid_amount',
        'due_amount',
        'amount',
        'status',
        'payment_date',
        'payment_method',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

}
