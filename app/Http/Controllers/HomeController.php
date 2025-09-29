<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status', 1)->take(4)->get();

        $categories = Category::with([
            'subcategories',
            'products' => function ($query) {
                $query->select('id', 'category_id', 'name', 'main_image', 'slug', 'regular_price', 'sale_price')
                      ->inRandomOrder()
                      ->take(8);
            }
        ])->withCount('products')->orderBy('name')->get();

        $manCategory = Category::where('slug', 'men')->with([
            'products' => function ($query) {
                $query->select('id', 'category_id', 'name','main_image', 'slug', 'regular_price', 'sale_price')
                      ->inRandomOrder()
                      ->take(8);
            }
        ])->first();

        $womenCategory = Category::where('slug', 'women')->with([
            'products' => function ($query) {
                $query->select('id', 'category_id', 'name', 'main_image', 'slug', 'regular_price', 'sale_price')
                      ->inRandomOrder()
                      ->take(8);
            }
        ])->first();

        $newArrivals = Product::with(['productVariations.colour'])
            ->select('id', 'name', 'main_image', 'slug', 'regular_price', 'sale_price', 'created_at')
            ->where('created_at', '>=', Carbon::now()->subDays(90))
            ->orderBy('created_at', 'DESC')
            ->take(8)
            ->get();

        $categories->load('subcategories.category');

        $allSubcategories = $categories->flatMap(function ($category) {
            return $category->subcategories;
        })->filter()->sortBy('name');

        $brands = Brand::orderBy('name')->get();

        // Get top 5 reviews for testimonials section
        $topReviews = Review::with('product')
            ->where('is_approved', true)
            ->where('rating', '>=', 4)
            ->orderBy('rating', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();

        return view('index', compact(
            'slides',
            'categories',
            'manCategory',
            'womenCategory',
            'newArrivals',
            'allSubcategories',
            'brands',
            'topReviews'
        ));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $productsQuery = $category->products()
            ->select('id', 'category_id', 'name', 'main_image', 'slug', 'regular_price', 'sale_price');

        $products = $productsQuery->paginate(12);

        // Get brands for filtering
        $brands = Brand::orderBy('name')->get();

        return view('category', compact('category', 'products', 'brands'));
    }

    public function subcategory($slug, $subcategory_id)
    {
        $subcategory = SubCategory::findOrFail($subcategory_id);

        $productsQuery = $subcategory->products()
            ->select('id', 'category_id', 'name', 'main_image', 'slug', 'regular_price', 'sale_price');

        $products = $productsQuery->paginate(12);
        $maxPrice = max(Product::max('regular_price'), Product::whereNotNull('sale_price')->max('sale_price') ?? 0);

        return view('subcategory', compact('subcategory', 'products', 'maxPrice'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = Product::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'main_image', 'slug', 'regular_price', 'sale_price')
            ->take(8)
            ->get();

        return view('shop.search', compact('results', 'query'));
    }

    public function contact()
    {
        return view('contact');
    }
}
