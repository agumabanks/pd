<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'shipment_line_id',
        'returned_quantity',
        'return_reason',
        'return_date'
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
