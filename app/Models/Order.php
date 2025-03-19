<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'supplier_id',
        'status',
        'change_order_status',
        'requested_delivery_date',
        'promised_delivery_date',
        'acknowledge_due_date',
        'pdf_url',
        'lifecycle_history',

         
        'po_number',
          
    ];
    public static function allStatuses()
{
    return [
        'Draft',
        'Approved',
        'Dispatched',
        'Shipped',
        'Delivered',
        'Invoiced',
        'Paid',
    ];
}


     // Example lifecycle statuses as constants:
        public const STATUS_DRAFT       = 'Draft';
        public const STATUS_APPROVED    = 'Approved';
        public const STATUS_DISPATCHED  = 'Dispatched';
        public const STATUS_SHIPPED     = 'Shipped';
        public const STATUS_DELIVERED   = 'Delivered';
        public const STATUS_INVOICED    = 'Invoiced';
        public const STATUS_PAID        = 'Paid';
    
        // If you want a helper to map all statuses:
        
    
        // belongsTo relationship if your "users" are "suppliers"
        public function supplier()
        {
            return $this->belongsTo(Supplier::class, 'supplier_id');
        }
    
        // Example method to move to next status:
        public function moveToNextStatus()
        {
            $statuses = self::allStatuses();
            $currentIndex = array_search($this->status, $statuses);
    
            // if not the last in array, increment
            if ($currentIndex !== false && $currentIndex < count($statuses) - 1) {
                $this->status = $statuses[$currentIndex + 1];
                $this->save();
            }
            // else do nothing or handle logic if it's already "Paid", etc.
        }
}
