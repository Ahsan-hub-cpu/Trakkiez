<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'short_description', 'description', 'regular_price',
        'sale_price', 'SKU', 'stock_status', 'featured', 'quantity',
        'image', 'images', 'size_chart', 'category_id', 'brand_id', 'subcategory_id'
    ];

    public function getHoverImageAttribute()
    {
        if (!empty($this->images)) {
            $galleryImages = explode(',', $this->images);
            return count($galleryImages) > 0 ? trim($galleryImages[0]) : 'default-hover.jpg';
        }
        return 'default-hover.jpg';
    }
    

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function productVariations()
    {
        return $this->hasMany(Product_Variations::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Sizes::class, 'product_variations', 'product_id', 'size_id');
    }

    public function isOutOfStock()
    {
        return $this->quantity <= 0;
    }

    public function getTotalQuantityAttribute()
    {
        return $this->productVariations->sum('quantity');
    }

     public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }
   
}
