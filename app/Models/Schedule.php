<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'requested_date',
        'promised_date',
        'status',
        'remarks',
        'quantity'
    ];

    /**
     * Each schedule belongs to one order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Helper: possible statuses
     */
    public static function allStatuses()
    {
        return [
            'Pending',
            'Acknowledged',
            'Partially Fulfilled',
            'Complete',
        ];
    }
}
