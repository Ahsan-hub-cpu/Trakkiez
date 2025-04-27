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
        $slides = Slide::where('status', 1)->take(3)->get();

        $categories = Category::with([
            'subcategories',
            'products' => function ($query) {
                $query->inRandomOrder()->take(8);
            }
        ])->orderBy('name')->get();

        $manCategory = Category::where('slug', 'men')->with([
            'subcategories',
            'products' => function ($query) {
                $query->inRandomOrder()->take(8);
            }
        ])->first();

        $womenCategory = Category::where('slug', 'women')->with([
            'subcategories',
            'products' => function ($query) {
                $query->inRandomOrder()->take(8);
            }
        ])->first();

        $sproducts = Product::whereNotNull('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->take(8)->get();
        $fproducts = Product::where('featured', 1)->take(8)->get();
        $newArrivals = Product::with(['productVariations.size'])
            ->where('created_at', '>=', Carbon::now()->subDays(15))
            ->orderBy('created_at', 'DESC')
            ->take(8)
            ->get();

        // Add hover image to each product in newArrivals using $product->images
        $newArrivals = $newArrivals->map(function ($product) {
            if (!empty($product->images)) {
                $galleryImages = explode(',', $product->images);
                $product->hover_image = count($galleryImages) > 0 ? trim($galleryImages[0]) : 'default-hover.jpg';
            } else {
                $product->hover_image = 'default-hover.jpg'; // Fallback image
            }
            return $product;
        });

        // Add hover image to each product in manCategory using $product->images
        if ($manCategory && $manCategory->products) {
            $manCategory->products = $manCategory->products->map(function ($product) {
                if (!empty($product->images)) {
                    $galleryImages = explode(',', $product->images);
                    $product->hover_image = count($galleryImages) > 0 ? trim($galleryImages[0]) : 'default-hover.jpg';
                } else {
                    $product->hover_image = 'default-hover.jpg'; // Fallback image
                }
                return $product;
            });
        }

        // Add hover image to each product in womenCategory using $product->images
        if ($womenCategory && $womenCategory->products) {
            $womenCategory->products = $womenCategory->products->map(function ($product) {
                if (!empty($product->images)) {
                    $galleryImages = explode(',', $product->images);
                    $product->hover_image = count($galleryImages) > 0 ? trim($galleryImages[0]) : 'default-hover.jpg';
                } else {
                    $product->hover_image = 'default-hover.jpg'; // Fallback image
                }
                return $product;
            });
        }

        $categories->load('subcategories.category');

        $allSubcategories = $categories->flatMap(function ($category) {
            return $category->subcategories;
        })->filter()->sortBy('name');

        return view('index', compact('slides', 'categories', 'manCategory', 'womenCategory', 'sproducts', 'fproducts', 'newArrivals', 'allSubcategories'));
    }

    public function category($category_slug, Request $request)
    {
        $category = Category::where('slug', $category_slug)->firstOrFail();

        $productsQuery = $category->products();

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

        // Always paginate, even with filters, to ensure $products is a LengthAwarePaginator
        $products = $productsQuery->paginate(16);

        // Add hover image to each product using $product->images
        $products->getCollection()->transform(function ($product) {
            if (!empty($product->images)) {
                $galleryImages = explode(',', $product->images);
                $product->hover_image = count($galleryImages) > 0 ? trim($galleryImages[0]) : 'default-hover.jpg';
            } else {
                $product->hover_image = 'default-hover.jpg'; // Fallback image
            }
            return $product;
        });

        return view('category', compact('category', 'products', 'sizes', 'maxPrice'));
    }

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

        // Always paginate, even with filters
        $products = $productsQuery->paginate(16);

        // Add hover image to each product using $product->images
        $products->getCollection()->transform(function ($product) {
            if (!empty($product->images)) {
                $galleryImages = explode(',', $product->images);
                $product->hover_image = count($galleryImages) > 0 ? trim($galleryImages[0]) : 'default-hover.jpg';
            } else {
                $product->hover_image = 'default-hover.jpg'; // Fallback image
            }
            return $product;
        });

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

        // Add hover image to search results using $product->images
        $results = $results->map(function ($product) {
            if (!empty($product->images)) {
                $galleryImages = explode(',', $product->images);
                $product->hover_image = count($galleryImages) > 0 ? trim($galleryImages[0]) : 'default-hover.jpg';
            } else {
                $product->hover_image = 'default-hover.jpg'; // Fallback image
            }
            return $product;
        });

        return response()->json($results);
    }
}