<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTracking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'delivery_tracking';

    protected $fillable = [
        'delivery_id',
        'status',
        'notes'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the delivery that owns the tracking record.
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * Get human-readable status.
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'assigned' => 'Delivery Assigned',
            'picked_up' => 'Order Picked Up',
            'in_transit' => 'On the Way',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'failed' => 'Delivery Failed',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    /**
     * Get status badge class for styling.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'assigned' => 'badge bg-secondary',
            'picked_up' => 'badge bg-info',
            'in_transit', 'out_for_delivery' => 'badge bg-warning',
            'delivered' => 'badge bg-success',
            'failed' => 'badge bg-danger',
            default => 'badge bg-secondary',
        };
    }

    /**
     * Get formatted created at.
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') : null;
    }

    /**
     * Get time ago (for timeline display).
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at ? $this->created_at->diffForHumans() : null;
    }
}