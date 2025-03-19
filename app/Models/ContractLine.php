<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'line_item',
        'description',
        'unit_price',
        'quantity',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
