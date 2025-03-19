<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'agreement_number',
        'legal_entity',
        'business_unit',
        'agreement_type',
        'agreement_status',
        'agreement_amount',
        'minimum_release_amount',
        'released_amount',
        'effective_date',
        'expiration_date'
    ];
}
