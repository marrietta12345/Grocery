<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'discount',
        'shipping_fee',
        'total',
        'promo_code',
        'status',
        'shipping_status',
        'payment_status',
        'payment_method',
        'shipping_address',
        'billing_address',
        'contact_phone',
        'contact_email',
        'notes',
        'paid_at',
        'cancellation_reason',
        'cancelled_at',
        'cancelled_by',
        'delivery_fee',
        'delivered_at',
        'tracking_number',
        'courier_name',
        'shipped_at',
        'out_for_delivery_at',
        'delivery_instructions',
        'arrived_at_sorting_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'total' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'delivered_at' => 'datetime',
        'shipped_at' => 'datetime',
        'out_for_delivery_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'arrived_at_sorting_at' => 'datetime',
    ];

    /**
     * The possible status values for orders.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_READY_FOR_DELIVERY = 'ready_for_delivery';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * The possible shipping status values.
     */
    const SHIPPING_PENDING = 'pending';
    const SHIPPING_PROCESSING = 'processing';
    const SHIPPING_SHIPPED = 'shipped';
    const SHIPPING_OUT_FOR_DELIVERY = 'out_for_delivery';
    const SHIPPING_DELIVERED = 'delivered';
    const SHIPPING_FAILED = 'failed';
    const SHIPPING_ARRIVED_AT_SORTING = 'arrived_at_sorting';

    /**
     * The possible payment status values.
     */
    const PAYMENT_UNPAID = 'unpaid';
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_REFUNDED = 'refunded';
    const PAYMENT_FAILED = 'failed';

    /**
     * The possible payment methods.
     */
    const METHOD_COD = 'cod';
    const METHOD_GCASH = 'gcash';
    const METHOD_PAYMAYA = 'paymaya';
    const METHOD_CREDIT_CARD = 'credit_card';
    const METHOD_DEBIT_CARD = 'debit_card';

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payment for the order.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the user who cancelled the order.
     */
    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * Get the delivery for the order.
     */
    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        
        return $prefix . '-' . $date . '-' . $random;
    }

    /**
     * Recalculate order totals based on items.
     */
    public function recalculateTotals()
    {
        $this->load('items');
        
        $subtotal = $this->items->sum('subtotal');
        $total = $subtotal - ($this->discount ?? 0) + ($this->shipping_fee ?? 0) + ($this->delivery_fee ?? 0);
        
        $this->update([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
        
        return $this;
    }

    /**
     * Check if order can be cancelled.
     */
    public function canBeCancelled()
    {
        // Order can be cancelled if not delivered and not completed
        if (in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_CANCELLED])) {
            return false;
        }

        // If order has delivery assigned but not yet picked up, can cancel
        if ($this->hasDelivery() && $this->delivery) {
            return $this->delivery->canBeCancelled();
        }

        // For orders without delivery yet
        if ($this->payment_method === self::METHOD_COD) {
            return true;
        }

        // For online payments, can cancel if not yet paid
        return in_array($this->payment_status, [self::PAYMENT_UNPAID, self::PAYMENT_PENDING]);
    }

    /**
     * Check if order needs payment.
     */
    public function needsPayment()
    {
        return $this->payment_method !== self::METHOD_COD && 
               in_array($this->payment_status, [self::PAYMENT_UNPAID, self::PAYMENT_PENDING, self::PAYMENT_FAILED]);
    }

    /**
     * Mark order as paid.
     */
    public function markAsPaid()
    {
        $this->update([
            'payment_status' => self::PAYMENT_PAID,
            'status' => self::STATUS_PROCESSING,
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark order as processing.
     */
    public function markAsProcessing()
    {
        $this->update([
            'status' => self::STATUS_PROCESSING,
        ]);
    }

    /**
     * Mark order as ready for delivery.
     */
    public function markAsReadyForDelivery()
    {
        $this->update([
            'status' => self::STATUS_READY_FOR_DELIVERY,
        ]);
    }

    /**
     * Mark order as shipped.
     */
    public function markAsShipped($trackingNumber = null, $courier = null)
    {
        $updateData = [
            'status' => self::STATUS_SHIPPED,
            'shipping_status' => self::SHIPPING_SHIPPED,
            'shipped_at' => now(),
        ];
        
        if ($trackingNumber) {
            $updateData['tracking_number'] = $trackingNumber;
        }
        
        if ($courier) {
            $updateData['courier_name'] = $courier;
        }
        
        $this->update($updateData);
        
        return $this;
    }

    /**
     * Mark order as out for delivery.
     */
    public function markAsOutForDelivery()
    {
        $this->update([
            'shipping_status' => self::SHIPPING_OUT_FOR_DELIVERY,
            'out_for_delivery_at' => now(),
        ]);
        
        return $this;
    }

    /**
     * Mark order as completed.
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
        ]);
    }

    /**
     * Mark order as delivered.
     */
    public function markAsDelivered()
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'shipping_status' => self::SHIPPING_DELIVERED,
            'delivered_at' => now(),
        ]);
        
        if ($this->hasDelivery() && $this->delivery) {
            $this->delivery->status = 'delivered';
            $this->delivery->delivered_at = now();
            $this->delivery->save();
            
            if ($this->delivery->deliveryPersonnel) {
                $personnel = $this->delivery->deliveryPersonnel;
                $personnel->increment('total_deliveries');
                $personnel->updateAvailability();
            }
        }
        
        return $this;
    }

    /**
     * Mark order as cancelled.
     */
    public function markAsCancelled($reason = null)
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'shipping_status' => self::SHIPPING_FAILED,
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
            'cancelled_by' => auth()->id(),
        ]);
        
        if ($this->hasDelivery() && $this->delivery && $this->delivery->canBeCancelled()) {
            $this->delivery->cancel($reason);
        }
    }

    /**
     * Check if order has delivery assigned.
     */
    public function hasDelivery()
    {
        return $this->delivery()->exists();
    }

    /**
     * Check if order is ready for delivery assignment.
     */
    public function isReadyForDelivery()
    {
        return in_array($this->status, [self::STATUS_PROCESSING, self::STATUS_READY_FOR_DELIVERY]) && 
               $this->payment_status === self::PAYMENT_PAID &&
               !$this->hasDelivery();
    }

    /**
     * Assign delivery to a personnel.
     */
    public function assignDelivery($deliveryPersonnelId)
    {
        if ($this->isReadyForDelivery()) {
            return Delivery::create([
                'order_id' => $this->id,
                'delivery_personnel_id' => $deliveryPersonnelId,
                'status' => 'assigned',
                'assigned_at' => now(),
            ]);
        }
        
        return null;
    }

    // ==================== ACCESSORS ====================

    /**
     * Get the full name of the customer.
     */
    public function getCustomerNameAttribute()
    {
        return $this->user ? $this->user->first_name . ' ' . $this->user->last_name : 'Guest';
    }

    /**
     * Get formatted status with badge class.
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'badge bg-warning text-dark',
            self::STATUS_PROCESSING => 'badge bg-info text-white',
            self::STATUS_READY_FOR_DELIVERY => 'badge bg-primary text-white',
            self::STATUS_SHIPPED => 'badge bg-primary text-white',
            self::STATUS_COMPLETED => 'badge bg-success',
            self::STATUS_CANCELLED => 'badge bg-danger',
            default => 'badge bg-secondary',
        };
    }

    /**
     * Get formatted shipping status with badge class.
     */
    public function getShippingStatusBadgeAttribute()
    {
        return match($this->shipping_status) {
            self::SHIPPING_PENDING => 'badge bg-secondary',
            self::SHIPPING_PROCESSING => 'badge bg-info',
            self::SHIPPING_ARRIVED_AT_SORTING => 'badge bg-primary', 
            self::SHIPPING_SHIPPED => 'badge bg-primary',
            self::SHIPPING_OUT_FOR_DELIVERY => 'badge bg-warning',
            self::SHIPPING_DELIVERED => 'badge bg-success',
            self::SHIPPING_FAILED => 'badge bg-danger',
            default => 'badge bg-secondary',
        };
    }

    /**
     * Get human-readable shipping status.
     */
    public function getShippingStatusTextAttribute()
    {
        return match($this->shipping_status) {
            self::SHIPPING_PENDING => 'Pending',
            self::SHIPPING_PROCESSING => 'Processing',
            self::SHIPPING_SHIPPED => 'Shipped',
            self::SHIPPING_OUT_FOR_DELIVERY => 'Out for Delivery',
            self::SHIPPING_ARRIVED_AT_SORTING => 'Arrived at Sorting Facility',
            self::SHIPPING_DELIVERED => 'Delivered',
            self::SHIPPING_FAILED => 'Failed',
            default => ucfirst($this->shipping_status),
        };
    }

    /**
     * Get tracking link - returns the tracking number entered by admin.
     */
    public function getTrackingLinkAttribute()
    {
        if (!$this->tracking_number) {
            return null;
        }
        
        // Return the tracking number directly (as entered by admin)
        return $this->tracking_number;
    }

    /**
     * Get formatted payment status with badge class.
     */
    public function getPaymentStatusBadgeAttribute()
    {
        return match($this->payment_status) {
            self::PAYMENT_PAID => 'badge bg-success',
            self::PAYMENT_UNPAID => 'badge bg-warning text-dark',
            self::PAYMENT_PENDING => 'badge bg-info text-white',
            self::PAYMENT_REFUNDED => 'badge bg-secondary',
            self::PAYMENT_FAILED => 'badge bg-danger',
            default => 'badge bg-secondary',
        };
    }

    /**
     * Get human-readable status.
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_READY_FOR_DELIVERY => 'Ready for Delivery',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get human-readable payment status.
     */
    public function getPaymentStatusTextAttribute()
    {
        return ucfirst($this->payment_status);
    }

    /**
     * Get human-readable payment method.
     */
    public function getPaymentMethodTextAttribute()
    {
        return match($this->payment_method) {
            self::METHOD_COD => 'Cash on Delivery',
            self::METHOD_GCASH => 'GCash',
            self::METHOD_PAYMAYA => 'PayMaya',
            self::METHOD_CREDIT_CARD => 'Credit Card',
            self::METHOD_DEBIT_CARD => 'Debit Card',
            default => ucfirst($this->payment_method),
        };
    }

    /**
     * Get delivery status if exists.
     */
    public function getDeliveryStatusAttribute()
    {
        if ($this->hasDelivery() && $this->delivery) {
            return $this->delivery->status_label;
        }
        return 'Not Assigned';
    }

    /**
     * Get delivery personnel if assigned.
     */
    public function getDeliveryPersonnelAttribute()
    {
        if ($this->hasDelivery() && $this->delivery && $this->delivery->deliveryPersonnel) {
            return $this->delivery->deliveryPersonnel;
        }
        return null;
    }

    /**
     * Get delivery timeline.
     */
    public function getDeliveryTimelineAttribute()
    {
        if (!$this->hasDelivery() || !$this->delivery) {
            return [];
        }
        
        $timeline = [];
        
        if ($this->delivery->assigned_at) {
            $timeline[] = [
                'status' => 'Assigned',
                'time' => $this->delivery->assigned_at,
                'icon' => 'bi bi-person-check',
                'description' => 'Delivery assigned to ' . ($this->deliveryPersonnel ? $this->deliveryPersonnel->user->full_name : 'rider')
            ];
        }
        
        if ($this->delivery->picked_up_at) {
            $timeline[] = [
                'status' => 'Picked Up',
                'time' => $this->delivery->picked_up_at,
                'icon' => 'bi bi-box-seam',
                'description' => 'Order picked up from store'
            ];
        }
        
        if ($this->delivery->delivered_at) {
            $timeline[] = [
                'status' => 'Delivered',
                'time' => $this->delivery->delivered_at,
                'icon' => 'bi bi-check-circle',
                'description' => 'Order delivered successfully'
            ];
        }
        
        return $timeline;
    }

    /**
     * Get shipping timeline.
     */
    public function getShippingTimelineAttribute()
    {
        $timeline = [];
        
        if ($this->shipped_at) {
            $timeline[] = [
                'status' => 'Shipped',
                'time' => $this->shipped_at,
                'icon' => 'bi bi-box-seam',
                'description' => 'Order has been shipped' . ($this->courier_name ? ' via ' . $this->courier_name : '')
            ];
        }
        
        if ($this->out_for_delivery_at) {
            $timeline[] = [
                'status' => 'Out for Delivery',
                'time' => $this->out_for_delivery_at,
                'icon' => 'bi bi-truck',
                'description' => 'Out for delivery to your address'
            ];
        }
        
        if ($this->delivered_at) {
            $timeline[] = [
                'status' => 'Delivered',
                'time' => $this->delivered_at,
                'icon' => 'bi bi-check-circle',
                'description' => 'Order delivered successfully'
            ];
        }
        
        return $timeline;
    }

    /**
     * Get formatted order number with prefix.
     */
    public function getFormattedOrderNumberAttribute()
    {
        return '#' . str_pad($this->order_number, 8, '0', STR_PAD_LEFT);
    }

    /**
     * Get total number of items in order.
     */
    public function getItemsCountAttribute()
    {
        return $this->items()->sum('quantity');
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include processing orders.
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    /**
     * Scope a query to only include ready for delivery orders.
     */
    public function scopeReadyForDelivery($query)
    {
        return $query->where('status', self::STATUS_READY_FOR_DELIVERY);
    }

    /**
     * Scope a query to only include shipped orders.
     */
    public function scopeShipped($query)
    {
        return $query->where('status', self::STATUS_SHIPPED);
    }

    /**
     * Scope a query to only include completed orders.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include cancelled orders.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    /**
     * Scope a query to only include orders with pending shipping.
     */
    public function scopeShippingPending($query)
    {
        return $query->where('shipping_status', self::SHIPPING_PENDING);
    }

    /**
     * Scope a query to only include shipped orders (by shipping status).
     */
    public function scopeShippingShipped($query)
    {
        return $query->where('shipping_status', self::SHIPPING_SHIPPED);
    }

    /**
     * Scope a query to only include delivered orders.
     */
    public function scopeShippingDelivered($query)
    {
        return $query->where('shipping_status', self::SHIPPING_DELIVERED);
    }

    /**
     * Scope a query to only include paid orders.
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }

    /**
     * Scope a query to only include unpaid orders.
     */
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_UNPAID);
    }

    /**
     * Scope a query to only include orders with pending payment.
     */
    public function scopePaymentPending($query)
    {
        return $query->where('payment_status', self::PAYMENT_PENDING);
    }

    /**
     * Scope a query to only include COD orders.
     */
    public function scopeCod($query)
    {
        return $query->where('payment_method', self::METHOD_COD);
    }

    /**
     * Scope a query to only include GCash orders.
     */
    public function scopeGcash($query)
    {
        return $query->where('payment_method', self::METHOD_GCASH);
    }

    /**
     * Scope a query to only include PayMaya orders.
     */
    public function scopePaymaya($query)
    {
        return $query->where('payment_method', self::METHOD_PAYMAYA);
    }

    /**
     * Scope a query to only include card orders.
     */
    public function scopeCard($query)
    {
        return $query->whereIn('payment_method', [self::METHOD_CREDIT_CARD, self::METHOD_DEBIT_CARD]);
    }

    /**
     * Scope a query to only include orders ready for delivery assignment.
     */
    public function scopeReadyForDeliveryAssignment($query)
    {
        return $query->whereIn('status', [self::STATUS_PROCESSING, self::STATUS_READY_FOR_DELIVERY])
                     ->where('payment_status', self::PAYMENT_PAID)
                     ->whereDoesntHave('delivery');
    }

    /**
     * Scope a query to only include orders with active delivery.
     */
    public function scopeWithActiveDelivery($query)
    {
        return $query->whereHas('delivery', function($q) {
            $q->whereIn('status', ['assigned', 'picked_up', 'in_transit']);
        });
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query to search orders.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('order_number', 'like', "%{$search}%")
              ->orWhere('contact_email', 'like', "%{$search}%")
              ->orWhere('contact_phone', 'like', "%{$search}%")
              ->orWhereHas('user', function($userQuery) use ($search) {
                  $userQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
              });
        });
    }

    /**
     * Scope a query to filter by date.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope a query to filter by current month.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    /**
     * Scope a query to filter by current year.
     */
    public function scopeThisYear($query)
    {
        return $query->whereYear('created_at', now()->year);
    }

    public function markAsArrivedAtSorting()
    {
        $this->update([
            'shipping_status' => self::SHIPPING_ARRIVED_AT_SORTING,
            'arrived_at_sorting_at' => now(),
        ]);
        
        return $this;
    }
}