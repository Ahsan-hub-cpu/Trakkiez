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
    // Display the homepage (unchanged)
    public function index()
    {
        $slides = Slide::where('status', 1)->take(3)->get();
        $categories = Category::with(['subcategories', 'products' => function ($query) {
            $query->inRandomOrder()->take(8);
        }])->orderBy('name')->get();
        $manCategory = Category::where('slug', 'men')->with(['products' => function ($query) {
            $query->inRandomOrder()->take(8);
        }])->first();
        $womenCategory = Category::where('slug', 'women')->with(['products' => function ($query) {
            $query->inRandomOrder()->take(8);
        }])->first();
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->take(8)->get();
        $fproducts = Product::where('featured', 1)->take(8)->get();
        $newArrivals = Product::with(['productVariations.size'])
            ->where('created_at', '>=', Carbon::now()->subDays(15))
            ->orderBy('created_at', 'DESC')
            ->take(8)
            ->get();
        return view('index', compact('slides', 'categories', 'manCategory', 'womenCategory', 'sproducts', 'fproducts', 'newArrivals'));
    }

    // Display products for a specific category with filters
public function category($category_slug, Request $request)
    {
        // Fetch category based on its slug
        $category = Category::where('slug', $category_slug)->firstOrFail();

        // Initialize product query for the category
        $productsQuery = $category->products();

        // Size filter
        if ($request->has('size')) {
            $productsQuery->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizes.id', $request->size);
            });
        }

        // Price range filter
        if ($request->has('price_from') || $request->has('price_to')) {
            $priceFrom = $request->get('price_from', 0);
            $priceTo = $request->get('price_to', null);

            if (!$priceTo) {
                $maxRegular = Product::max('regular_price');
                $maxSale = Product::whereNotNull('sale_price')->max('sale_price');
                $priceTo = max($maxRegular, $maxSale);
            }

            $productsQuery->whereRaw("IFNULL(sale_price, regular_price) BETWEEN ? AND ?", [$priceFrom, $priceTo]);
        }

        // Sorting
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

        // Fetch sizes for filter dropdown
        $sizes = Sizes::all();

        // Calculate max price for price filter modal
        $maxRegular = Product::max('regular_price');
        $maxSale = Product::whereNotNull('sale_price')->max('sale_price');
        $maxPrice = max($maxRegular, $maxSale);

        // Paginate or get results
        if ($request->has('size') || $request->has('price_from') || $request->has('price_to') || $request->has('sort')) {
            $products = $productsQuery->get(); // Use get() when filters are applied, as in ShopController
        } else {
            $products = $productsQuery->paginate(16); // Use pagination by default
        }

        // Return the category products view
        return view('category', compact('category', 'products', 'sizes', 'maxPrice'));
    }
    // Display products for a specific subcategory with filters
  public function subcategory($category_slug, $subcategory_id, Request $request)
    {
        if (!is_numeric($subcategory_id)) {
            abort(404);
        }

        $category = Category::where('slug', $category_slug)->firstOrFail();
        $subcategory = SubCategory::where('category_id', $category->id)->findOrFail($subcategory_id);

        $productsQuery = $subcategory->products();

        if ($request->has('size')) {
            $productsQuery->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizes.id', $request->size);
            });
        }

        if ($request->has('price_from') || $request->has('price_to')) {
            $priceFrom = $request->get('price_from', 0);
            $priceTo = $request->get('price_to', null);

            if (!$priceTo) {
                $maxRegular = Product::max('regular_price');
                $maxSale = Product::whereNotNull('sale_price')->max('sale_price');
                $priceTo = max($maxRegular, $maxSale);
            }

            $productsQuery->whereRaw("IFNULL(sale_price, regular_price) BETWEEN ? AND ?", [$priceFrom, $priceTo]);
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

        $sizes = Sizes::all();
        $maxRegular = Product::max('regular_price');
        $maxSale = Product::whereNotNull('sale_price')->max('sale_price');
        $maxPrice = max($maxRegular, $maxSale);

        if ($request->has('size') || $request->has('price_from') || $request->has('price_to') || $request->has('sort')) {
            $products = $productsQuery->get();
        } else {
            $products = $productsQuery->paginate(16);
        }

        $noProductsMessage = $products->isEmpty() ? 'No products found for this subcategory' : null;

        return view('subcategory', compact('category', 'subcategory', 'products', 'sizes', 'maxPrice', 'noProductsMessage'));
    }
    // Other methods (unchanged)
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
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();
        return redirect()->back()->with('success', 'Your message has been sent successfully');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->take(8)->get();
        return response()->json($results);
    }
}