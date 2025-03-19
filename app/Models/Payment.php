<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_number',
        'invoice_id',
        'payment_date',
        'amount_paid',
        'currency',
        'payment_method',
        'notes'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
