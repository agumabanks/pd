<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'item_code',
        'description',
        'quantity',
        'unit_price'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
