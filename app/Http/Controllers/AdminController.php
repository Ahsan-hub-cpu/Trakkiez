<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Sizes;
use App\Models\Product_Variations;
use App\Models\Transaction;
use App\Models\OrderItem;
use App\Models\Slide;
use App\Models\Contact;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    
public function GenerateBrandThumbailImage($img , $imgName){

    $destinationPath = base_path('uploads/brands');
    $img = Image::read($img->path());
    $img->cover(124,124,"top");
    $img->resize(124,124,function($constraint){
        $constraint->aspectRatio();
    })->save($destinationPath.'/'.$imgName);
 }

public function index(){
        $orders=Order::orderBy('created_at','DESC')->get()->take(10);
        $dashboardDatas = DB::select("SELECT 
    SUM(total) AS TotalAmount,
    SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
    SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
    SUM(IF(status='canceled', total, 0)) AS TotalCanceledAmount,
    COUNT(*) AS Total,
    SUM(IF(status='ordered', 1, 0)) AS TotalOrdered,
    SUM(IF(status='delivered', 1, 0)) AS TotalDelivered,
    SUM(IF(status='canceled', 1, 0)) AS TotalCanceled
FROM orders");

   $monthlyDatas = DB::select("SELECT M.id As MonthNo, M.name As MonthName,
   IFNULL(D.TotalAmount,0) As TotalAmount,
   IFNULL(D.TotalOrderedAmount,0) As TotalOrderedAmount,
   IFNULL(D.TotalDeliveredAmount,0) As TotalDeliveredAmount,
   IFNULL(D.TotalCanceledAmount,0) As TotalCanceledAmount FROM month_names M
   LEFT JOIN (Select DATE_FORMAT(created_at, '%b') As MonthName,
   MONTH(created_at) As MonthNo,
   sum(total) As TotalAmount,
   sum(if(status='ordered',total,0)) As TotalOrderedAmount,
   sum(if(status='delivered',total,0)) As TotalDeliveredAmount,
   sum(if(status='canceled',total,0)) As TotalCanceledAmount
   From orders WHERE YEAR(created_at)=YEAR(NOW()) GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
   Order By MONTH(created_at)) D On D.MonthNo=M.id");

   $AmountM = implode(',',collect($monthlyDatas)->pluck('TotalAmount')->toArray());
   $orderedAmountM = implode(',',collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
   $deliveredAmountM = implode(',',collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
   $canceledAmountM = implode(',',collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());

   $totalAmount = collect($monthlyDatas)->sum('TotalAmount');
   $totalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
   $totalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
   $totalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');

    return view('admin.index',compact("orders","dashboardDatas","AmountM","orderedAmountM","deliveredAmountM","canceledAmountM","totalAmount","totalOrderedAmount","totalDeliveredAmount","totalCanceledAmount"));
    }

    public function brands(){
        $brands = Brand::orderBy('id','DESC')->paginate(10);
        return view("admin.brands",compact('brands'));
}

public function add_brand(){
     return view("admin.brand-add");
}

public function add_brand_store(Request $request){        
     $request->validate([
          'name' => 'required',
          'slug' => 'required|unique:brands,slug',
          'image' => 'mimes:png,jpg,jpeg,avif|max:2048'
     ]);

     $brand = new Brand();
     $brand->name = $request->name;
     $brand->slug = Str::slug($request->name);
     $image = $request->file('image');
     $file_extention = $request->file('image')->extension();
     $file_name = Carbon::now()->timestamp . '.' . $file_extention;        
     $this->GenerateBrandThumbailImage($image,$file_name);
     $brand->image = $file_name;        
     $brand->save();
     return redirect()->route('admin.brands')->with('status','Record has been added successfully !');
}
 
public function edit_brand($id){
     $brand = Brand::find($id);
     return view('admin.brand-edit',compact('brand'));
 }

   public function update_brand(Request $request){
    $request->validate([
        'name' => 'required',
        'slug' => 'required|unique:brands,slug,'.$request->id,
        'image' => 'mimes:png,jpg,jpeg|max:2048'
    ]);
    $brand = Brand::find($request->id);
    $brand->name = $request->name;
    $brand->slug = $request->slug;
    if($request->hasFile('image'))
    {            
        if (File::exists(public_path('uploads/brands').'/'.$brand->image)) {
            File::delete(public_path('uploads/brands').'/'.$brand->image);
        }
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateBrandThumbailImage($image,$file_name);
        $brand->image = $file_name;
    }        
    $brand->save();        
    return redirect()->route('admin.brands')->with('status','Record has been updated successfully !');
}
public function delete_brand($id){
    $brand = Brand::find($id);
    if (File::exists(public_path('uploads/brands').'/'.$brand->image)) {
        File::delete(public_path('uploads/brands').'/'.$brand->image);
    }
    $brand->delete();
    return redirect()->route('admin.brands')->with('status','Record has been deleted successfully !');
}

public function GenerateCategoryThumbailImage($img , $imgName){

    $destinationPath = base_path('uploads/categories');
    $img = Image::read($img->path());
    $img->cover(124,124,"top");
    $img->resize(124,124,function($constraint){
        $constraint->aspectRatio();
    })->save($destinationPath.'/'.$imgName);
 }


 public function add_category(){
    return view("admin.category-add");
}

public function categories()
    {
        $categories = Category::with('subcategories')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function add_category_store(Request $request) {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpg,jpeg,avif|max:2048',
            'subcategories.*.name' => 'required|string|max:255',
        ]);
    
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $image->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateCategoryThumbailImage($image, $file_name);
        $category->image = $file_name;        
        $category->save();

        if ($request->has('subcategories')) {
            foreach ($request->subcategories as $subcategoryData) {
                SubCategory::create([
                    'name' => $subcategoryData['name'],
                    'category_id' => $category->id, 
                ]);
            }
        }
    
        return redirect()->route('admin.categories')->with('status', 'Category has been added successfully!');
    }

public function edit_category($id)
{
    $category = Category::with('subcategories')->findOrFail($id);
    return view('admin.category-edit', compact('category'));
}

public function update_category(Request $request)
{
    $category = Category::findOrFail($request->id);

    $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'subcategories.*.id' => 'nullable|integer|exists:subcategories,id',
        'subcategories.*.name' => 'nullable|string|max:255',
    ]);


    $category->name = $request->name;
    $category->slug = $request->slug;


    if($request->hasFile('image'))
    {            
        if (File::exists(public_path('uploads/categories').'/'.$category->image)) {
            File::delete(public_path('uploads/categories').'/'.$category->image);
        }
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateCategoryThumbailImage($image,$file_name);
        $category->image = $file_name;
    }        

    $category->save();


    $existingSubcategoryIds = $category->subcategories->pluck('id')->toArray();
    $newSubcategoryIds = [];

    if ($request->has('subcategories')) {
        foreach ($request->subcategories as $subcategoryData) {
            if (!empty($subcategoryData['id'])) {
             
                $subcategory = Subcategory::find($subcategoryData['id']);
                if ($subcategory) {
                    $subcategory->name = $subcategoryData['name'];
                    $subcategory->save();
                    $newSubcategoryIds[] = $subcategory->id;
                }
            } else {
                $subcategory = new Subcategory();
                $subcategory->name = $subcategoryData['name'];
                $subcategory->category_id = $category->id;
                $subcategory->save();
                $newSubcategoryIds[] = $subcategory->id;
            }
        }
    }
    $subcategoriesToDelete = array_diff($existingSubcategoryIds, $newSubcategoryIds);
    Subcategory::whereIn('id', $subcategoriesToDelete)->delete();

    return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
}


public function delete_category($id) {
    $category = Category::find($id);
    if (File::exists(public_path('uploads/categories').'/'.$category->image)) {
        File::delete(public_path('uploads/categories').'/'.$category->image);
    }
    $category->delete();
    return redirect()->route('admin.categories')->with('status', 'Category has been deleted successfully!');
}


// ---- Product Methods ---- //


  public function products()
    {
        $products = Product::with(['productVariations.size'])->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function add_product()
    {
        $categories = Category::with('subcategories')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        $sizes = Sizes::all();
        return view("admin.product-add", compact('categories', 'brands', 'sizes'));
    }

public function product_store(Request $request)
{
    // Validate the data
    $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'required|unique:products,slug',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
        'short_description' => 'required|string',
        'description' => 'required|string',
        'regular_price' => 'required|numeric|min:0',
        'sale_price' => 'nullable|numeric|min:0',
        'SKU' => 'required|string|max:255',
        'stock_status' => 'required|in:instock,outofstock',
        'featured' => 'required|boolean',
        'quantity' => 'required|integer|min:0',
        'image' => 'required|mimes:png,jpg,jpeg,avif,webp|max:4048',
        'size_charts' => 'nullable|array',
        'size_charts.*' => 'mimes:png,jpg,jpeg,avif,webp|max:4048',
        'sizes' => 'required|array',
        'sizes.*' => 'exists:sizes,id',
        'size_stock' => 'required|array',
        'subcategory_id' => 'required|exists:sub_categories,id',
        'images' => 'nullable|array',
        'images.*' => 'mimes:png,jpg,jpeg,avif,webp|max:4048',
    ], [
        'size_charts.*.mimes' => 'Each size chart must be an image (PNG, JPG, JPEG, AVIF, or WEBP).',
        'size_charts.*.max' => 'Each size chart image may not be larger than 4MB.',
        'images.*.mimes' => 'Each gallery image must be an image (PNG, JPG, JPEG, AVIF, or WEBP).',
        'images.*.max' => 'Each gallery image may not be larger than 4MB.',
    ]);

    // Calculate total quantity from sizes
    $totalSizeQuantity = array_sum($request->size_stock);

    // Check if global quantity matches total size quantity
    if ($totalSizeQuantity != $request->quantity) {
        return back()->withErrors(['quantity' => 'The global quantity must match the sum of the quantities of each size.']);
    }

    // Create the product
    $product = new Product();
    $product->name = $request->name;
    $product->slug = Str::slug($request->name);
    $product->short_description = $request->short_description;
    $product->description = $request->description;
    $product->regular_price = $request->regular_price;
    $product->sale_price = $request->sale_price;
    $product->SKU = $request->SKU;
    $product->stock_status = $request->stock_status;
    $product->featured = $request->featured;
    $product->quantity = $request->quantity;
    $product->category_id = $request->category_id;
    $product->subcategory_id = $request->subcategory_id;

    // Handle main image upload
    $current_timestamp = Carbon::now()->timestamp;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = $current_timestamp . '.webp';
        $this->GenerateThumbnailImage($image, $imageName);
        $product->image = $imageName;
    }

    // Handle size chart images
    $size_chart_arr = [];
    if ($request->hasFile('size_charts')) {
        $allowedfileExtension = ['jpg', 'png', 'jpeg', 'avif', 'webp'];
        $files = $request->file('size_charts');
        foreach ($files as $index => $file) {
            $extension = strtolower($file->getClientOriginalExtension());
            if (in_array($extension, $allowedfileExtension)) {
                $filename = 'chart_' . $current_timestamp . '-' . ($index + 1) . '.webp';
                $this->GenerateThumbnailImage($file, $filename);
                $size_chart_arr[] = $filename;
            }
        }
        $product->size_chart = implode(',', $size_chart_arr);
    }

    // Handle gallery images
    $gallery_arr = [];
    if ($request->hasFile('images')) {
        $allowedfileExtension = ['jpg', 'png', 'jpeg', 'avif', 'webp'];
        $files = $request->file('images');
        foreach ($files as $index => $file) {
            $extension = strtolower($file->getClientOriginalExtension());
            if (in_array($extension, $allowedfileExtension)) {
                $filename = $current_timestamp . '-' . ($index + 1) . '.webp';
                try {
                    $this->GenerateThumbnailImage($file, $filename);
                    $gallery_arr[] = $filename;
                } catch (\Exception $e) {
                    \Log::error('Error processing gallery image: ' . $e->getMessage(), [
                        'filename' => $file->getClientOriginalName(),
                        'generatedName' => $filename
                    ]);
                    // Continue processing other images instead of stopping
                    continue;
                }
            }
        }
        $product->images = implode(',', $gallery_arr);
    }

    $product->brand_id = $request->brand_id;
    $product->save();

    // Save product variations
    foreach ($request->sizes as $size_id) {
        Product_Variations::create([
            'product_id' => $product->id,
            'size_id' => $size_id,
            'price' => $request->regular_price,
            'quantity' => $request->size_stock[$size_id],
        ]);
    }

    return redirect()->route('admin.products')->with('status', 'Product added successfully!');
}

    public function edit_product($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::with('subcategories')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        $sizes = Sizes::all();
        $productVariations = Product_Variations::where('product_id', $product->id)->get();
        $selectedCategory = $product->category;
        $selectedSubcategory = $product->subcategory;

        return view('admin.product-edit', compact('product', 'categories', 'brands', 'sizes', 'productVariations', 'selectedCategory', 'selectedSubcategory'));
    }

    public function update_product(Request $request)
    {
        // Validate the data
        $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:products,slug,' . $request->id,
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'SKU' => 'required|string|max:255',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'required|boolean',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|mimes:png,jpg,jpeg,avif,webp|max:20000',
            'size_charts' => 'nullable|array',
            'size_charts.*' => 'mimes:png,jpg,jpeg,avif,webp|max:4048',
            'remove_size_charts' => 'nullable|boolean',
            'sizes' => 'required|array',
            'sizes.*' => 'exists:sizes,id',
            'size_stock' => 'required|array',
        ], [
            'size_charts.*.mimes' => 'Each size chart must be an image (PNG, JPG, JPEG, AVIF, or WEBP).',
            'size_charts.*.max' => 'Each size chart image may not be larger than 4MB.',
        ]);

        $product = Product::findOrFail($request->id);

        // Calculate total quantity from sizes
        $totalSizeQuantity = array_sum($request->size_stock);

        // Check if global quantity matches total size quantity
        if ($totalSizeQuantity != $request->quantity) {
            return back()->withErrors(['quantity' => 'The global quantity must match the sum of the quantities of each size.']);
        }

        // Update product details
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;

        // Handle main image upload
        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('uploads/products/' . $product->image))) {
                File::delete(base_path('uploads/products/' . $product->image));
                File::delete(base_path('uploads/products/thumbnails/' . $product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.webp';
            $this->GenerateThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        // Handle size chart images update
        if ($request->input('remove_size_charts') && $product->size_chart) {
            foreach (explode(',', $product->size_chart) as $oldChart) {
                if (File::exists(base_path('uploads/products/' . $oldChart))) {
                    File::delete(base_path('uploads/products/' . $oldChart));
                    File::delete(base_path('uploads/products/thumbnails/' . $oldChart));
                }
            }
            $product->size_chart = null;
        } elseif ($request->hasFile('size_charts')) {
            if ($product->size_chart) {
                foreach (explode(',', $product->size_chart) as $oldChart) {
                    if (File::exists(base_path('uploads/products/' . $oldChart))) {
                        File::delete(base_path('uploads/products/' . $oldChart));
                        File::delete(base_path('uploads/products/thumbnails/' . $oldChart));
                    }
                }
            }

            $size_chart_arr = [];
            foreach ($request->file('size_charts') as $index => $file) {
                $filename = 'chart_' . time() . '-' . ($index + 1) . '.webp';
                $this->GenerateThumbnailImage($file, $filename);
                $size_chart_arr[] = $filename;
            }
            $product->size_chart = implode(',', $size_chart_arr);
        }

        // Handle gallery images update
        if ($request->hasFile('images')) {
            if ($product->images) {
                foreach (explode(',', $product->images) as $oldImage) {
                    if (File::exists(base_path('uploads/products/' . $oldImage))) {
                        File::delete(base_path('uploads/products/' . $oldImage));
                        File::delete(base_path('uploads/products/thumbnails/' . $oldImage));
                    }
                }
            }

            $gallery_arr = [];
            foreach ($request->file('images') as $index => $file) {
                $filename = time() . '-' . ($index + 1) . '.webp';
                $this->GenerateThumbnailImage($file, $filename);
                $gallery_arr[] = $filename;
            }
            $product->images = implode(',', $gallery_arr);
        }

        $product->brand_id = $request->brand_id;
        $product->save();

        // Update product variations
        Product_Variations::where('product_id', $product->id)->delete();
        foreach ($request->sizes as $size_id) {
            Product_Variations::create([
                'product_id' => $product->id,
                'size_id' => $size_id,
                'price' => $request->regular_price,
                'quantity' => $request->size_stock[$size_id],
            ]);
        }

        return redirect()->route('admin.products')->with('status', 'Product updated successfully!');
    }

    public function delete_product($id)
    {
        $product = Product::findOrFail($id);

        // Delete main image
        if ($product->image && File::exists(public_path('uploads/products/' . $product->image))) {
            File::delete(base_path('uploads/products/' . $product->image));
            File::delete(base_path('uploads/products/thumbnails/' . $product->image));
        }

        // Delete size chart images
        if ($product->size_chart) {
            foreach (explode(',', $product->size_chart) as $chart) {
                if (File::exists(base_path('uploads/products/' . $chart))) {
                    File::delete(base_path('uploads/products/' . $chart));
                    File::delete(base_path('uploads/products/thumbnails/' . $chart));
                }
            }
        }

        // Delete gallery images
        if ($product->images) {
            foreach (explode(',', $product->images) as $image) {
                if (File::exists(base_path('uploads/products/' . $image))) {
                    File::delete(base_path('uploads/products/' . $image));
                    File::delete(base_path('uploads/products/thumbnails/' . $image));
                }
            }
        }

        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully!');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json(['subcategories' => $subcategories]);
    }

public function GenerateThumbnailImage($img, $imgName)
{
    $destinationPath = base_path('uploads/products');
    $thumbnailPath = base_path('uploads/products/thumbnails');

    // Ensure directories exist
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }
    if (!file_exists($thumbnailPath)) {
        mkdir($thumbnailPath, 0755, true);
    }

    try {
        // Validate image size (e.g., max 5MB)
        if ($img->getSize() > 5 * 1024 * 1024) {
            throw new \Exception('Image size exceeds 5MB limit');
        }

        // Read image once
        $image = Image::read($img->path());

        // Limit dimensions for large images
        $image->scaleDown(1200, 1200); // Max 1200x1200 pixels

        // Save original as WebP with reduced quality
        $image->toWebp(100)->save($destinationPath . '/' . $imgName);

        // Create thumbnail from the same image instance
        $thumbnail = $image->cover(100, 100, 'center')
                          ->toWebp(100)
                          ->save($thumbnailPath . '/' . $imgName);

    } catch (\Exception $e) {
        \Log::error('Error in GenerateThumbnailImage: ' . $e->getMessage(), [
            'imgName' => $imgName,
            'originalName' => $img->getClientOriginalName(),
            'destinationPath' => $destinationPath,
            'thumbnailPath' => $thumbnailPath,
            'fileSize' => $img->getSize(),
        ]);
        throw $e; // Rethrow to catch in product_store
    }
}
public function coupons(){
        $coupons = Coupon::orderBy("expiry_date","DESC")->paginate(12);
        return view("admin.coupons",compact("coupons"));
}

public function add_coupon(){        
    return view("admin.coupons-add");
}


public function add_coupon_store(Request $request)
{
    $request->validate([
        'code' => 'required',
        'type' => 'required',
        'value' => 'required|numeric',
        'cart_value' => 'required|numeric',
        'expiry_date' => 'required|date'
    ]);

    $coupon = new Coupon();
    $coupon->code = $request->code;
    $coupon->type = $request->type;
    $coupon->value = $request->value;
    $coupon->cart_value = $request->cart_value;
    $coupon->expiry_date = $request->expiry_date;
    $coupon->save();
    return redirect()->route("admin.coupons")->with('status','Record has been added successfully !');
}

public function edit_coupon($id){
       $coupon = Coupon::find($id);
       return view('admin.coupon-edit',compact('coupon'));
}

public function update_coupon(Request $request)
{
       $request->validate([
       'code' => 'required',
       'type' => 'required',
       'value' => 'required|numeric',
       'cart_value' => 'required|numeric',
       'expiry_date' => 'required|date'
       ]);

       $coupon = Coupon::find($request->id);
       $coupon->code = $request->code;
       $coupon->type = $request->type;
       $coupon->value = $request->value;
       $coupon->cart_value = $request->cart_value;
       $coupon->expiry_date = $request->expiry_date;               
       $coupon->save();           
       return redirect()->route('admin.coupons')->with('status','Record has been updated successfully !');
}

public function delete_coupon($id){
        $coupon = Coupon::find($id);        
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('status','Record has been deleted successfully !');
}

public function orders(){
        $orders = Order::orderBy('created_at','DESC')->paginate(12);
        return view("admin.orders",compact('orders'));
}

public function order_items($order_id){
    $order = Order::find($order_id);
      $orderitems = OrderItem::where('order_id',$order_id)->orderBy('id')->paginate(12);
      $transaction = Transaction::where('order_id',$order_id)->first();
      return view("admin.orders-details",compact('order','orderitems','transaction'));
}


public function update_order_status(Request $request){        
    $order = Order::find($request->order_id);
    $order->status = $request->order_status;
    if($request->order_status=='delivered')
    {
        $order->delivered_date = Carbon::now();
    }
    else if($request->order_status=='canceled')
    {
        $order->canceled_date = Carbon::now();
    }        
    $order->save();
    if($request->order_status=='delivered')
    {
        $transaction = Transaction::where('order_id',$request->order_id)->first();
        $transaction->status = "approved";
        $transaction->save();
    }
    return back()->with("status", "Status changed successfully!");
}


public function slides(){
    $slides = Slide::orderBy('id','DESC')->paginate(12);
    return view('admin.slides', compact('slides'));
}


public function slide_add(){
    return view('admin.slide-add');
}


public function slide_store(Request $request){
    $request->validate([
    //   'tagline' => 'required',
    //   'title' => 'required',
    //   'subtitle' => 'required',
    //   'link' => 'required',
       'status' => 'required',
       'image' => 'required|mimes:png,jpg,jpeg,avif,webp|max:2048'
    ]);
    $slide = new Slide();
    // $slide->tagline = $request->tagline;
    // $slide->title = $request->title;
    // $slide->subtitle = $request->subtitle;
    // $slide->link = $request->link;
    $slide->status = $request->status;
     $image = $request->file('image');
    $file_extention = $request->file('image')->extension();
    $file_name = Carbon::now()->timestamp . '.' . $file_extention;
    $this->GenerateSlideThumbnailImage($image,$file_name);
    $slide->image = $file_name;  
    $slide->save();
    return redirect()->route('admin.slides')->with("status","Slide added successfully!");
}

public function GenerateSlideThumbnailImage($img, $imgName)
{
    $destinationPath = base_path('uploads/slides');

    // Load image from the temporary upload path
    $image = Image::read($img->path());

    // Cover crop to fit exactly 1550x660, focus on center
    $image->cover(1280, 720, 'center');

    // Optional: resize again for optimization (usually not needed after cover)
    $image->resize(1280, 720, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize(); // Prevent enlarging smaller images
    });

    // Save to your destination
    $image->save($destinationPath . '/' . $imgName);
}


public function slide_edit($id){
    $slide = Slide::find($id);
    return view('admin.slide-edit',compact('slide'));
}



public function slide_update(Request $request){
    $request->validate([
        // 'tagline' => 'required',
        // 'title' => 'required',
        // 'subtitle' => 'required',
        // 'link' => 'required',
        'status' => 'required',
        'image' => 'mimes:png,jpg,jpeg,avif,webp|max:2048'
     ]);
     $slide = Slide::find($request->id);
    //  $slide->tagline = $request->tagline;
    //  $slide->title = $request->title;
    //  $slide->subtitle = $request->subtitle;
    //  $slide->link = $request->link;
     $slide->status = $request->status;

     if($request->hasFile('image'))
     {
        if(File::exists(public_path('uploads/slides'). '/' . $slide->image)){
            File::delete(public_path('uploads/slides'). '/' . $slide->image);
        }
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateSlideThumbnailImage($image,$file_name);
        $slide->image = $file_name; 
     } 
     $slide->save();
     return redirect()->route('admin.slides')->with("status","Slide has been Updated successfully!");
}

public function slide_delete($id){
    $slide = Slide::find($id);
    if(File::exists(public_path('uploads/slides'). '/' . $slide->image)){
        File::delete(public_path('uploads/slides'). '/' . $slide->image);
    }
    $slide->delete();
    return redirect()->route('admin.slides')->with("status","Slide has been Deleted successfully!");

   }

  public function contacts(){
    $contacts = Contact::orderBy('created_at','DESC')->paginate(10);
    return view('admin.contacts', compact('contacts'));
  }
  public function contact_delete($id){
    $contact = Contact::find($id);
    $contact->delete();
    return redirect()->route('admin.contacts')->with('success','Contact deleted successfully');
}

public function search(Request $request){
    $query = $request->input('query');
    $results = Product::where('name','LIKE',"%{$query}%")->get()->take(8);
    return response()->json($results);
}

 public function reviews()
    {
        $reviews = Review::with('product')->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.review', compact('reviews'));
    }

    public function approve_review($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);
        return redirect()->route('admin.reviews')->with('status', 'Review approved successfully!');
    }

    public function delete_review($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('admin.reviews')->with('status', 'Review deleted successfully!');
    }

}
