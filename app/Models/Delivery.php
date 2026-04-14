<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'delivery_personnel_id',
        'status',
        'assigned_at',
        'picked_up_at',
        'delivered_at',
        'delivery_notes',
        'proof_of_delivery'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Get the order associated with the delivery.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the delivery personnel associated with the delivery.
     */
    public function deliveryPersonnel()
    {
        return $this->belongsTo(DeliveryPersonnel::class);
    }

    /**
     * Get the tracking records for the delivery.
     */
    public function tracking()
    {
        return $this->hasMany(DeliveryTracking::class);
    }

    /**
     * Add a tracking entry.
     */
    public function addTracking($status, $notes = null, $latitude = null, $longitude = null)
    {
        return $this->tracking()->create([
            'status' => $status,
            'notes' => $notes,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'assigned' => 'badge bg-info',
            'picked_up' => 'badge bg-primary',
            'in_transit' => 'badge bg-warning',
            'delivered' => 'badge bg-success',
            'failed' => 'badge bg-danger',
            default => 'badge bg-secondary',
        };
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'assigned' => 'Assigned',
            'picked_up' => 'Picked Up',
            'in_transit' => 'In Transit',
            'delivered' => 'Delivered',
            'failed' => 'Failed',
            default => ucfirst($this->status),
        };
    }

    /**
     * Scope for active deliveries.
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['assigned', 'picked_up', 'in_transit']);
    }

    /**
     * Scope for completed deliveries.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Check if delivery can be cancelled.
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['assigned', 'picked_up']);
    }

    /**
     * Cancel the delivery.
     */
    public function cancel($reason = null)
    {
        $this->status = 'failed';
        $this->delivery_notes = $reason;
        $this->save();
        
        $this->addTracking('failed', $reason);
        
        // Update delivery personnel availability
        if ($this->deliveryPersonnel) {
            $this->deliveryPersonnel->updateAvailability();
        }
        
        return $this;
    }
}