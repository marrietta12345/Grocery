<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'brand',
        'category_id', 
        'description',
        'price',
        'old_price',
        'stock',
        'sku',
        'weight',
        'unit',
        'image',
        'gallery',
        'is_featured',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'weight' => 'decimal:2',
        'gallery' => 'array',
    ];

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . uniqid();
            }
            
            if (empty($product->meta_title)) {
                $product->meta_title = $product->name;
            }
            
            if (empty($product->meta_description)) {
                $product->meta_description = Str::limit($product->description, 160);
            }
        });


        static::updated(function ($product) {
            if ($product->wasChanged('category_id')) {
               
            }
        });
    }

    /**
     * Get the category that owns this product
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the category name 
     */
    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : null;
    }

    /**
     * Scope a query to filter by category
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to filter by category name
     */
    public function scopeInCategoryName($query, $categoryName)
    {
        return $query->whereHas('category', function($q) use ($categoryName) {
            $q->where('name', $categoryName);
        });
    }

    /**
     * Get the formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return '₱' . number_format($this->price, 2);
    }

    /**
     * Get the formatted old price
     */
    public function getFormattedOldPriceAttribute()
    {
        return $this->old_price ? '₱' . number_format($this->old_price, 2) : null;
    }

    /**
     * Get the discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->old_price && $this->old_price > $this->price) {
            return round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return 0;
    }

    /**
     * Check if product is in stock
     */
    public function getInStockAttribute()
    {
        return $this->stock > 0;
    }

    /**
     * Check if product has discount
     */
    public function getHasDiscountAttribute()
    {
        return $this->old_price && $this->old_price > $this->price;
    }

    /**
     * Get stock status
     */
    public function getStockStatusAttribute()
    {
        if ($this->stock <= 10) {
            return ['label' => 'Out of Stock', 'class' => 'danger'];
        } elseif ($this->stock < 10) {
            return ['label' => 'Low Stock', 'class' => 'warning'];
        } else {
            return ['label' => 'In Stock', 'class' => 'success'];
        }
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Get gallery image URLs
     */
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) {
            return [];
        }
        
        return collect($this->gallery)->map(function ($image) {
            return asset('storage/' . $image);
        })->toArray();
    }

    /**
     * Scope a query to only include active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include in-stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include low stock products
     */
    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('stock', '>', 0)
                     ->where('stock', '<', $threshold);
    }

    /**
     * Scope a query to only include out of stock products
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    /**
     * Get the ratings for the product.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get average rating for the product.
     */
    public function getAverageRatingAttribute()
    {
        return round($this->ratings()->avg('rating') ?? 0, 1);
    }

    /**
     * Get total rating count.
     */
    public function getRatingCountAttribute()
    {
        return $this->ratings()->count();
    }

    /**
     * Get rating distribution (1-5 stars).
     */
    public function getRatingDistributionAttribute()
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $this->ratings()->where('rating', $i)->count();
        }
        return $distribution;
    }

}