<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'rating',
        'review',
        'images',
        'title',
        'is_verified_purchase',
        'reviewed_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'images' => 'array',
        'is_verified_purchase' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the order that owns the rating.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user that owns the rating.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the rating.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get star rating HTML.
     */
    public function getStarRatingAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="bi bi-star-fill text-warning"></i>';
            } else {
                $stars .= '<i class="bi bi-star text-muted"></i>';
            }
        }
        return $stars;
    }

    /**
     * Scope to get average rating for a product.
     */
    public function scopeAverageRating($query, $productId)
    {
        return $query->where('product_id', $productId)->avg('rating');
    }

    /**
     * Scope to get rating count for a product.
     */
    public function scopeRatingCount($query, $productId)
    {
        return $query->where('product_id', $productId)->count();
    }
}