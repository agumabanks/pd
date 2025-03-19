<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_number',
        'status',
        'shipped_date',
        'expected_receipt_date',
        'actual_receipt_date',
        'incoterm',
        'shipping_method',
        'bol_awb_number',
        'comments',
        'attachments'
    ];

    public function lines()
    {
        return $this->hasMany(ShipmentLine::class);
    }

    public function receipts()
    {
        return $this->hasMany(ShipmentReceipt::class);
    }

    public function returns()
    {
        return $this->hasMany(ShipmentReturn::class);
    }
}
