<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Supplier extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'taxpayer_id',
        'country_of_taxation',
        'country_of_origin',
        'supplier_type',
        'first_name',
        'last_name',
        'email',
        'is_administrative_contact',
        'addresses',
        'business_classifications',
        'bank_accounts',
        'product_categories',
        'questionnaire',
        'password',
    ];

    protected $casts = [
        'addresses' => 'array',
        'business_classifications' => 'array',
        'bank_accounts' => 'array',
        'product_categories' => 'array',
        'questionnaire' => 'array',
    ];
}
