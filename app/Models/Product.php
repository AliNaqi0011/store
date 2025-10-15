<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory; // Temporarily disabled Searchable

    protected $fillable = [
        'name', 'slug', 'description', 'short_description', 'sku', 'price', 'compare_price',
        'stock_quantity', 'manage_stock', 'in_stock', 'is_active', 'is_featured', 'is_deal', 'is_new_arrival',
        'weight', 'dimensions', 'category_id', 'brand_id', 'rating', 'reviews_count'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'dimensions' => 'array',
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_deal' => 'boolean',
        'is_new_arrival' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeDeals($query)
    {
        return $query->where('is_deal', true);
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('is_new_arrival', true)->orderBy('created_at', 'desc');
    }

    public function scopeInStock($query)
    {
        return $query->where(function($q) {
            $q->where('manage_stock', false)
              ->orWhere(function($subQ) {
                  $subQ->where('manage_stock', true)
                       ->where('stock_quantity', '>', 0);
              });
        });
    }

    public function getIsInStockAttribute()
    {
        if (!$this->manage_stock) {
            return true;
        }
        return $this->stock_quantity > 0;
    }

    public function getPrimaryImageAttribute()
    {
        $primaryImage = $this->images()->where('is_primary', true)->first();
        return $primaryImage ? $primaryImage->image_path : null;
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'sku' => $this->sku,
            'category' => $this->category->name ?? '',
            'brand' => $this->brand->name ?? '',
        ];
    }
}