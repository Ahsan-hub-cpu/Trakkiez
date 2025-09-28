<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'regular_price',
        'sale_price',
        'stock_status',
        'featured',
        'main_image',
        'gallery_images',
        'category_id',
        'subcategory_id',
        'brand_id',
        'SKU',
    ];

    protected $casts = [
        'gallery_images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productVariations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function getTotalQuantityAttribute()
    {
        return $this->productVariations->sum('quantity');
    }

    public function isOutOfStock()
    {
        return $this->total_quantity <= 0;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }
}