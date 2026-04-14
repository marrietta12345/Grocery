<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPersonnel extends Model
{
    use HasFactory;

    protected $table = 'delivery_personnel';

    protected $fillable = [
        'user_id',
        'phone_number',
        'vehicle_type',
        'license_plate',
        'availability_status',
        'current_latitude',
        'current_longitude',
        'total_deliveries',
        'rating',
        'rating_count'
    ];

    protected $casts = [
        'current_latitude' => 'decimal:8',
        'current_longitude' => 'decimal:8',
        'rating' => 'decimal:2',
        'total_deliveries' => 'integer',
        'rating_count' => 'integer',
    ];

    /**
     * Get the user associated with the delivery personnel.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the deliveries for the delivery personnel.
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    /**
     * Get active deliveries (not yet delivered).
     */
    public function activeDeliveries()
    {
        return $this->deliveries()->whereIn('status', ['assigned', 'picked_up', 'in_transit']);
    }

    /**
     * Get completed deliveries.
     */
    public function completedDeliveries()
    {
        return $this->deliveries()->where('status', 'delivered');
    }

    /**
     * Update availability status based on active deliveries.
     */
    public function updateAvailability()
    {
        $hasActiveDelivery = $this->activeDeliveries()->exists();
        $this->availability_status = $hasActiveDelivery ? 'busy' : 'available';
        $this->save();
        
        return $this;
    }

    /**
     * Calculate average rating.
     */
    public function calculateAverageRating()
    {
        if ($this->rating_count > 0) {
            $this->rating = $this->rating / $this->rating_count;
            $this->save();
        }
        
        return $this->rating;
    }

    /**
     * Add a new rating.
     */
    public function addRating($newRating)
    {
        $totalRating = ($this->rating * $this->rating_count) + $newRating;
        $this->rating_count++;
        $this->rating = $totalRating / $this->rating_count;
        $this->save();
        
        return $this;
    }

    /**
     * Get the delivery personnel's full name.
     */
    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->full_name : 'Unknown';
    }

    /**
     * Get the vehicle type with icon.
     */
    public function getVehicleIconAttribute()
    {
        return match($this->vehicle_type) {
            'motorcycle' => 'bi bi-bicycle',
            'car' => 'bi bi-car-front',
            'bicycle' => 'bi bi-bicycle',
            default => 'bi bi-truck',
        };
    }

    /**
     * Get availability badge class.
     */
    public function getAvailabilityBadgeClassAttribute()
    {
        return match($this->availability_status) {
            'available' => 'badge bg-success',
            'busy' => 'badge bg-warning',
            'offline' => 'badge bg-secondary',
            default => 'badge bg-secondary',
        };
    }

    /**
     * Get the current delivery if any.
     */
    public function getCurrentDeliveryAttribute()
    {
        return $this->activeDeliveries()->first();
    }

    /**
     * Get total deliveries count.
     */
    public function getTotalDeliveriesCountAttribute()
    {
        return $this->deliveries()->count();
    }

    /**
     * Get today's deliveries count.
     */
    public function getTodayDeliveriesCountAttribute()
    {
        return $this->deliveries()
            ->whereDate('created_at', today())
            ->count();
    }

    /**
     * Get rating percentage (for star display).
     */
    public function getRatingPercentageAttribute()
    {
        return ($this->rating / 5) * 100;
    }

    /**
     * Get formatted rating with decimal.
     */
    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }

    /**
     * Check if delivery personnel is available.
     */
    public function isAvailable()
    {
        return $this->availability_status === 'available';
    }

    /**
     * Check if delivery personnel is busy.
     */
    public function isBusy()
    {
        return $this->availability_status === 'busy';
    }

    /**
     * Check if delivery personnel is offline.
     */
    public function isOffline()
    {
        return $this->availability_status === 'offline';
    }

    /**
     * Get delivery personnel's phone number formatted.
     */
    public function getFormattedPhoneAttribute()
    {
        if (!$this->phone_number) {
            return 'N/A';
        }
        
        // Format: +63 912 345 6789
        $phone = preg_replace('/[^0-9]/', '', $this->phone_number);
        if (strlen($phone) == 10) {
            return '+63 ' . substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6, 4);
        }
        
        return $this->phone_number;
    }

    /**
     * Get vehicle display name.
     */
    public function getVehicleDisplayAttribute()
    {
        return match($this->vehicle_type) {
            'motorcycle' => 'Motorcycle',
            'car' => 'Car',
            'bicycle' => 'Bicycle',
            default => 'Not specified',
        };
    }

    /**
     * Scope a query to only include available personnel.
     */
    public function scopeAvailable($query)
    {
        return $query->where('availability_status', 'available');
    }

    /**
     * Scope a query to only include busy personnel.
     */
    public function scopeBusy($query)
    {
        return $query->where('availability_status', 'busy');
    }

    /**
     * Scope a query to only include offline personnel.
     */
    public function scopeOffline($query)
    {
        return $query->where('availability_status', 'offline');
    }

    /**
     * Scope a query to only include personnel by vehicle type.
     */
    public function scopeByVehicleType($query, $type)
    {
        return $query->where('vehicle_type', $type);
    }

    /**
     * Scope a query to only include personnel with minimum rating.
     */
    public function scopeMinRating($query, $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    /**
     * Scope a query to order by rating (highest first).
     */
    public function scopeHighestRated($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    /**
     * Scope a query to order by most deliveries.
     */
    public function scopeMostActive($query)
    {
        return $query->orderBy('total_deliveries', 'desc');
    }
}