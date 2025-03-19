<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'status',
        'invoice_date',
        'due_date',
        'subtotal',
        'tax_amount',
        'total',
        'currency',
        'reference',
        'attachments',
        'notes'
    ];

    public function lines()
    {
        return $this->hasMany(InvoiceLine::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * getPaidAmount: sum of all payments
     */
    public function getPaidAmountAttribute()
    {
        return $this->payments()->sum('amount_paid');
    }

    /**
     * getBalanceDue: difference between total and paid amount
     */
    public function getBalanceDueAttribute()
    {
        return $this->total - $this->paid_amount;
    }
}
