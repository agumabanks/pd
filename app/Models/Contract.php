<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_number',
        'title',
        'description',
        'status',
        'effective_date',
        'expiration_date',
        'total_value',
        'currency',
        'attachments',           // JSON field
        'supplier_id',           // Link to a supplier or user table
        'lifecycle_stage',       // e.g. 'Draft', 'Active', 'Renewed', 'Expired', etc.
        'auto_renew',           // bool
        'max_renewals',         // int
        'current_renewal_count',// int
        'risk_level',           // e.g. 'Low', 'Medium', 'High'
        'amendments',           // JSON field for minor changes or notes
        'performance_rating',    // e.g. numeric rating, or store in separate table
    ];

    protected $casts = [
        'attachments' => 'array',
        'amendments'  => 'array',
        'effective_date'  => 'datetime',
        'expiration_date' => 'datetime',
        'auto_renew'      => 'boolean',
    ];

    public function lines()
    {
        return $this->hasMany(ContractLine::class);
    }

    public function revisions()
    {
        return $this->hasMany(ContractRevision::class);
    }

    // Example: If you have a Supplier model
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Check if contract is currently active.
     */
    public function isActive()
    {
        return $this->status === 'Active';
    }

    /**
     * Helper to determine if contract is near expiration.
     */
    public function isNearExpiration($days = 30)
    {
        if (!$this->expiration_date) {
            return false;
        }
        return now()->diffInDays($this->expiration_date, false) <= $days;
    }

    /**
     * Lifecycle stages for reference:
     */
    public static function lifecycleStages()
    {
        return [
            'Draft',
            'Pending Approval',
            'Active',
            'Renewed',
            'Expired',
            'Terminated',
        ];
    }
}
