<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'duns_number',
        'taxpayer_id',
        'company_name',
        'contact_details',
        'legal_address',
        'women_ownership_document',
        'banking_proof',
        'registration_documents',
        'director_first_name',
        'director_last_name',
        'email',
        'activation_code',
        'user_first_name',
        'user_last_name',
        'user_email',
        'password',
        'source',
        'referral_comments',
        'email_preference',
        'terms_accepted',
    ];
}
