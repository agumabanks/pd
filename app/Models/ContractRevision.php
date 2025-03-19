<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractRevision extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'revision_number',
        'revision_notes',
        'revision_status',
        'initiated_by'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
