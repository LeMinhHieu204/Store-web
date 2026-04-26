<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'original_price',
        'price',
        'thumbnail',
        'file_path',
        'category_id',
        'is_featured',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    public function getDisplayOriginalPriceAttribute(): float
    {
        return (float) ($this->original_price ?: $this->price);
    }

    public function getDisplaySalePriceAttribute(): float
    {
        return (float) $this->price;
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->original_price !== null && (float) $this->original_price > (float) $this->price;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
