<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get active promotions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            });
    }

    /**
     * Check if promotion is valid
     */
    public function isValid($orderAmount = null)
    {
        // Log the validation check for debugging
        \Log::info('Validating promotion: ' . $this->code, [
            'is_active' => $this->is_active,
            'starts_at' => $this->starts_at,
            'expires_at' => $this->expires_at,
            'usage_limit' => $this->usage_limit,
            'used_count' => $this->used_count,
            'min_order_amount' => $this->min_order_amount,
            'order_amount' => $orderAmount
        ]);

        if (!$this->is_active) {
            \Log::info('Promotion invalid: not active');
            return false;
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            \Log::info('Promotion invalid: not started yet', [
                'starts_at' => $this->starts_at->format('Y-m-d H:i:s'),
                'now' => now()->format('Y-m-d H:i:s')
            ]);
            return false;
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            \Log::info('Promotion invalid: expired', [
                'expires_at' => $this->expires_at->format('Y-m-d H:i:s'),
                'now' => now()->format('Y-m-d H:i:s')
            ]);
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            \Log::info('Promotion invalid: usage limit reached', [
                'used' => $this->used_count,
                'limit' => $this->usage_limit
            ]);
            return false;
        }

        if ($orderAmount !== null && $this->min_order_amount && $orderAmount < $this->min_order_amount) {
            \Log::info('Promotion invalid: minimum order not met', [
                'required' => $this->min_order_amount,
                'actual' => $orderAmount
            ]);
            return false;
        }

        \Log::info('Promotion valid');
        return true;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount($amount)
    {
        if ($this->type === 'percentage') {
            $discount = ($amount * $this->value) / 100;
            \Log::info('Percentage discount calculated', [
                'amount' => $amount,
                'percentage' => $this->value,
                'discount' => $discount
            ]);
            return $discount;
        }

        $discount = min($this->value, $amount);
        \Log::info('Fixed discount calculated', [
            'amount' => $amount,
            'fixed_value' => $this->value,
            'discount' => $discount
        ]);
        return $discount;
    }

    /**
     * Get formatted discount text
     */
    public function getDiscountTextAttribute()
    {
        if ($this->type === 'percentage') {
            return $this->value . '% OFF';
        }
        return '₱' . number_format($this->value, 2) . ' OFF';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        if (!$this->is_active) {
            return 'Inactive';
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return 'Scheduled';
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return 'Expired';
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return 'Used Up';
        }

        return 'Active';
    }

    /**
     * Get status color for badges
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status_text) {
            case 'Active':
                return 'success';
            case 'Scheduled':
                return 'info';
            case 'Expired':
                return 'secondary';
            case 'Used Up':
                return 'warning';
            case 'Inactive':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    /**
     * Increment usage count
     */
    public function incrementUsage()
    {
        $this->increment('used_count');
        \Log::info('Promotion usage incremented', [
            'code' => $this->code,
            'new_count' => $this->used_count
        ]);
    }

    /**
     * Decrement usage count
     */
    public function decrementUsage()
    {
        if ($this->used_count > 0) {
            $this->decrement('used_count');
            \Log::info('Promotion usage decremented', [
                'code' => $this->code,
                'new_count' => $this->used_count
            ]);
        }
    }

    /**
     * Check if promotion can be used for given amount
     */
    public function canBeUsed($orderAmount = null)
    {
        return $this->isValid($orderAmount);
    }

    /**
     * Get remaining uses
     */
    public function getRemainingUsesAttribute()
    {
        if (!$this->usage_limit) {
            return 'Unlimited';
        }
        
        $remaining = $this->usage_limit - $this->used_count;
        return max(0, $remaining);
    }

    /**
     * Scope for valid promotions
     */
    public function scopeValid($query, $orderAmount = null)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->where(function($q) use ($orderAmount) {
                if ($orderAmount) {
                    $q->where(function($sub) use ($orderAmount) {
                        $sub->whereNull('min_order_amount')
                             ->orWhere('min_order_amount', '<=', $orderAmount);
                    });
                }
            })
            ->where(function($q) {
                $q->whereNull('usage_limit')
                   ->orWhereColumn('used_count', '<', 'usage_limit');
            });
    }
}