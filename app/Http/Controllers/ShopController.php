<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Sizes;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $productsQuery = Product::query()->select('id', 'name', 'image', 'slug', 'regular_price', 'sale_price', 'quantity', 'created_at', 'featured', 'category_id')
                                       ->with(['category', 'productVariations.size']);
        
        if ($request->query('filter') === 'featured') {
            $productsQuery->where('featured', true);
        } elseif ($request->query('filter') === 'new-arrivals') {
            $productsQuery->where('created_at', '>=', now()->subDays(90));
        } elseif ($request->query('filter') === 'hot-deals') {
            $productsQuery->whereNotNull('sale_price');
        }

        if ($request->has('category')) {
            $productsQuery->where('category_id', $request->category);
        }

        if ($request->has('size')) {
            $productsQuery->whereHas('sizes', function($q) use ($request) {
                $q->where('sizes.id', $request->size);
            });
        }

        if ($request->has('price_from') || $request->has('price_to')) {
            $priceFrom = $request->get('price_from', 0);
            $priceTo = $request->get('price_to', max(Product::max('regular_price'), Product::whereNotNull('sale_price')->max('sale_price') ?? 0));
            $productsQuery->whereRaw("IFNULL(sale_price, regular_price) BETWEEN ? AND ?", [$priceFrom, $priceTo]);
        } elseif ($request->has('price')) {
            $priceRange = explode('-', $request->price);
            $productsQuery->whereBetween('regular_price', [$priceRange[0], $priceRange[1]]);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $productsQuery->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $productsQuery->orderBy('created_at', 'asc');
                    break;
                case 'a-z':
                    $productsQuery->orderBy('name', 'asc');
                    break;
                case 'z-a':
                    $productsQuery->orderBy('name', 'desc');
                    break;
                case 'price-low-high':
                    $productsQuery->orderByRaw("IFNULL(sale_price, regular_price) ASC");
                    break;
                case 'price-high-low':
                    $productsQuery->orderByRaw("IFNULL(sale_price, regular_price) DESC");
                    break;
                default:
                    $productsQuery->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $productsQuery->orderBy('created_at', 'desc');
        }

        $categories = Category::all();
        $sizes = Sizes::all();
        $maxPrice = max(Product::max('regular_price'), Product::whereNotNull('sale_price')->max('sale_price') ?? 0);

        $products = ($request->has('size') || $request->has('price') || $request->has('price_from') || 
                     $request->has('price_to') || $request->has('sort') || $request->has('category'))
            ? $productsQuery->get()
            : $productsQuery->paginate(12);
      
        return view('shop', compact('products', 'categories', 'sizes', 'maxPrice'));
    }

    public function product_details(Request $request, $product_slug)
    {
        $product = Product::where('slug', $product_slug)
                         ->select('size_chart', 'id', 'name', 'image', 'images', 'slug', 'regular_price', 'sale_price', 'quantity', 'description', 'short_description', 'SKU', 'category_id')
                         ->with(['category', 'productVariations.size', 'reviews' => function ($query) {
                             $query->where('is_approved', true); // Only load approved reviews
                         }])
                         ->firstOrFail();

        $reviews = $product->reviews()->where('is_approved', true)->paginate(5); // Paginate with 5 reviews per page
        $averageRating = $product->reviews->avg('rating') ?? 0; // Default to 0 if no reviews
        $reviewCount = $product->reviews->count();

        $rproducts = Product::where('slug', '<>', $product_slug)
                           ->select('id', 'name', 'image', 'slug', 'regular_price', 'sale_price', 'quantity', 'category_id')
                           ->with(['category', 'productVariations.size'])
                           ->inRandomOrder()
                           ->take(8)
                           ->get();

        if ($request->ajax()) {
            return view('partials.reviews-list', compact('reviews'))->render();
        }

        return view('details', compact('product', 'rproducts', 'reviews', 'averageRating', 'reviewCount'));
    }
}