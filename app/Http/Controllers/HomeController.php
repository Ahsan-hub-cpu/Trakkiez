<?php
namespace App\Http\Controllers;

use App\Models\Slide;
use App\Models\Sizes;
use App\Models\Category;
use App\Models\Product;
use App\Models\Contact;
use App\Models\SubCategory;
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
                $query->select('category_id', 'id', 'name', 'image', 'slug', 'regular_price', 'sale_price', 'quantity')
                      ->inRandomOrder()
                      ->take(8);
            }
        ])->orderBy('name')->get();

        $manCategory = Category::where('slug', 'men')->with([
            'products' => function ($query) {
                $query->select('category_id', 'id', 'name','image', 'slug', 'regular_price', 'sale_price', 'quantity')
                      ->inRandomOrder()
                      ->take(8);
            }
        ])->first();

        $womenCategory = Category::where('slug', 'women')->with([
            'products' => function ($query) {
                $query->select('category_id', 'id', 'name', 'image', 'slug', 'regular_price', 'sale_price', 'quantity')
                      ->inRandomOrder()
                      ->take(8);
            }
        ])->first();

        // $sproducts = Product::whereNotNull('sale_price')
        //                    ->where('sale_price', '<>', '')
        //                    ->select('id', 'name', 'image', 'slug', 'regular_price', 'sale_price', 'quantity')
        //                    ->inRandomOrder()
        //                    ->take(8)
        //                    ->get();

        // $fproducts = Product::where('featured', 1)
        //                    ->select('id', 'name', 'image', 'slug', 'regular_price', 'sale_price', 'quantity')
        //                    ->take(8)
        //                    ->get();

        $newArrivals = Product::with(['productVariations.size'])
            ->select('id', 'name', 'image', 'slug', 'regular_price', 'sale_price', 'quantity', 'created_at')
            ->where('created_at', '>=', Carbon::now()->subDays(90))
            ->orderBy('created_at', 'DESC')
            ->take(8)
            ->get();

        $categories->load('subcategories.category');

        $allSubcategories = $categories->flatMap(function ($category) {
            return $category->subcategories;
        })->filter()->sortBy('name');

        return view('index', compact('slides', 'categories', 'manCategory', 'womenCategory',  'newArrivals', 'allSubcategories'));
    }

    public function category($category_slug, Request $request)
    {
        $category = Category::where('slug', $category_slug)->firstOrFail();
        $productsQuery = $category->products()->select('id', 'category_id', 'name', 'image', 'slug', 'regular_price', 'sale_price', 'quantity');

        if ($request->has('size')) {
            $productsQuery->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizes.id', $request->size);
            });
        }

        if ($request->has('price_from') || $request->has('price_to')) {
            $priceFrom = $request->get('price_from', 0);
            $priceTo = $request->get('price_to', max(Product::max('regular_price'), Product::whereNotNull('sale_price')->max('sale_price')));
            $productsQuery->whereRaw("IFNULL(sale_price, regular_price) BETWEEN ? AND ?", [$priceFrom, $priceTo]);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest': $productsQuery->orderBy('created_at', 'desc'); break;
                case 'oldest': $productsQuery->orderBy('created_at', 'asc'); break;
                case 'a-z': $productsQuery->orderBy('name', 'asc'); break;
                case 'z-a': $productsQuery->orderBy('name', 'desc'); break;
                case 'price-low-high': $productsQuery->orderByRaw("IFNULL(sale_price, regular_price) ASC"); break;
                case 'price-high-low': $productsQuery->orderByRaw("IFNULL(sale_price, regular_price) DESC"); break;
                default: $productsQuery->orderBy('created_at', 'desc'); break;
            }
        } else {
            $productsQuery->orderBy('created_at', 'desc');
        }

        $sizes = Sizes::all();
        $maxPrice = max(Product::max('regular_price'), Product::whereNotNull('sale_price')->max('sale_price'));
        $products = $productsQuery->paginate(16);

        return view('category', compact('category', 'products', 'sizes', 'maxPrice'));
    }

    public function subcategory($category_slug, $subcategory_id, Request $request)
    {
        $category = Category::where('slug', $category_slug)->firstOrFail();
        $subcategory = SubCategory::where('category_id', $category->id)->findOrFail($subcategory_id);
        $productsQuery = $subcategory->products()->select('id', 'category_id', 'name', 'image', 'slug', 'regular_price', 'sale_price', 'quantity');

        if ($request->has('size')) {
            $productsQuery->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizes.id', $request->size);
            });
        }

        if ($request->has('price_from') || $request->has('price_to')) {
            $priceFrom = $request->get('price_from', 0);
            $priceTo = $request->get('price_to', max(Product::max('regular_price'), Product::whereNotNull('sale_price')->max('sale_price')));
            $productsQuery->whereRaw("IFNULL(sale_price, regular_price) BETWEEN ? AND ?", [$priceFrom, $priceTo]);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest': $productsQuery->orderBy('created_at', 'desc'); break;
                case 'oldest': $productsQuery->orderBy('created_at', 'asc'); break;
                case 'a-z': $productsQuery->orderBy('name', 'asc'); break;
                case 'z-a': $productsQuery->orderBy('name', 'desc'); break;
                case 'price-low-high': $productsQuery->orderByRaw("IFNULL(sale_price, regular_price) ASC"); break;
                case 'price-high-low': $productsQuery->orderByRaw("IFNULL(sale_price, regular_price) DESC"); break;
                default: $productsQuery->orderBy('created_at', 'desc'); break;
            }
        } else {
            $productsQuery->orderBy('created_at', 'desc');
        }

        $sizes = Sizes::all();
        $maxPrice = max(Product::max('regular_price'), Product::whereNotNull('sale_price')->max('sale_price'));
        $products = $productsQuery->paginate(16);
        $noProductsMessage = $products->isEmpty() ? 'No products found for this subcategory' : null;

        return view('subcategory', compact('category', 'subcategory', 'products', 'sizes', 'maxPrice', 'noProductsMessage'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function contact_store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'comment' => 'required',
        ]);

        Contact::create($request->only(['name', 'email', 'phone', 'comment']));
        return redirect()->back()->with('success', 'Your message has been sent successfully');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")
                         ->select('id', 'name', 'image', 'slug', 'regular_price', 'sale_price', 'quantity')
                         ->take(8)
                         ->get();

        return response()->json($results);
    }
}