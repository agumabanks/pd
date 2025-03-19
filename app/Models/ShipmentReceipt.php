<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'shipment_line_id',
        'received_quantity',
        'receipt_date',
        'remarks'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function line()
    {
        return $this->belongsTo(ShipmentLine::class, 'shipment_line_id');
    }
}
