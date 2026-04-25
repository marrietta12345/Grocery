<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name', 
        'last_name',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the user's full name with middle initial.
     */
    public function getFullNameWithMiddleAttribute()
    {
        $middleInitial = $this->middle_name ? substr($this->middle_name, 0, 1) . '.' : '';
        return trim($this->first_name . ' ' . $middleInitial . ' ' . $this->last_name);
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the cart items for the user.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the ratings for the user.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the addresses for the user.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get the delivery personnel record for the user.
     */
    public function deliveryPersonnel()
    {
        return $this->hasOne(DeliveryPersonnel::class);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is delivery personnel.
     */
    public function isDelivery()
    {
        return $this->role === 'delivery';
    }

    /**
     * Check if user is a regular customer.
     */
    public function isCustomer()
    {
        return $this->role === 'user';
    }

    /**
     * Check if user is active.
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Get the user's avatar initials.
     */
    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    /**
     * Get the user's role badge class.
     */
    public function getRoleBadgeClassAttribute()
    {
        return match($this->role) {
            'admin' => 'badge bg-danger',
            'delivery' => 'badge bg-info',
            default => 'badge bg-success',
        };
    }

    /**
     * Get the user's role display name.
     */
    public function getRoleDisplayAttribute()
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'delivery' => 'Delivery Personnel',
            default => 'Customer',
        };
    }

    /**
     * Scope a query to only include delivery personnel.
     */
    public function scopeDeliveryPersonnel($query)
    {
        return $query->where('role', 'delivery');
    }

    /**
     * Scope a query to only include customers.
     */
    public function scopeCustomers($query)
    {
        return $query->where('role', 'user');
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the user's total orders count.
     */
    public function getTotalOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    /**
     * Get the user's total spent amount.
     */
    public function getTotalSpentAttribute()
    {
        return $this->orders()
            ->where('status', 'completed')
            ->sum('total');
    }

    /**
     * Get the user's recent orders.
     */
    public function recentOrders($limit = 5)
    {
        return $this->orders()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get delivery statistics for delivery personnel.
     */
    public function getDeliveryStatsAttribute()
    {
        if (!$this->isDelivery() || !$this->deliveryPersonnel) {
            return null;
        }

        $deliveryPersonnel = $this->deliveryPersonnel;
        
        return [
            'total_deliveries' => $deliveryPersonnel->total_deliveries,
            'completed_today' => $deliveryPersonnel->deliveries()
                ->where('status', 'delivered')
                ->whereDate('delivered_at', today())
                ->count(),
            'active_deliveries' => $deliveryPersonnel->deliveries()
                ->whereIn('status', ['assigned', 'picked_up', 'in_transit'])
                ->count(),
            'rating' => $deliveryPersonnel->rating,
            'availability_status' => $deliveryPersonnel->availability_status,
            'vehicle_type' => $deliveryPersonnel->vehicle_type,
        ];
    }

    /**
     * Check if delivery personnel is available for new deliveries.
     */
    public function isAvailableForDelivery()
    {
        return $this->isDelivery() && 
               $this->deliveryPersonnel && 
               $this->deliveryPersonnel->availability_status === 'available';
    }
}