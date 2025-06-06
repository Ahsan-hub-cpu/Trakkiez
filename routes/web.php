<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/shop/{product_slug}',[ShopController::class,'product_details'])->name("shop.product.details");
Route::post('/filter-products', [ShopController::class, 'filterProducts'])->name('shop.filter');
Route::get('/category/{category_slug}', [HomeController::class, 'category'])->name('home.category');
Route::get('/category/{category_slug}/{subcategory_id}', [HomeController::class, 'subcategory'])->name('home.subcategory');


//CART Updated
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/partial', [CartController::class, 'getCartPartial'])->name('cart.partial');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::get('/cart/check-quantity', [CartController::class, 'checkQuantity'])->name('cart.checkQuantity');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [CartController::class, 'remove_coupon_code'])->name('cart.removeCoupon');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/place-order', [CartController::class, 'place_order'])->name('cart.placeOrder');
Route::get('/confirmation', [CartController::class, 'confirmation'])->name('cart.confirmation');
Route::get('/cart/checkout/totals', [CartController::class, 'getCheckoutTotals'])->name('cart.checkout.totals');

//Wishlist
Route::post('/wishlist/add',[WishlistController::class,'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist',[WishlistController::class,'index'])->name('wishlist.index');
Route::delete('/wishlist/remove/{rowId}',[WishlistController::class,'remove_item_from_wishlist'])->name('wishlist.remove');
Route::delete('/wishlist/clear',[WishlistController::class,'empty_wishlist'])->name('wishlist.empty');
Route::post('/wishlist/move-to-cart/{rowId}',[WishlistController::class,'move_to_cart'])->name('wishlist.move.to.cart');

//coupon
// Route::post('/cart/apply-coupon',[CartController::class,'apply_coupon_code'])->name('cart.coupon.apply');
// Route::delete('/cart/remove-coupon',[CartController::class,'remove_coupon_code'])->name('cart.coupon.remove');

// Route::get('/checkout',[CartController::class,'checkout'])->name('cart.checkout');
// Route::post('/place-order',[CartController::class,'place_order'])->name('cart.place.order');
// Route::get('/order-confirmation',[CartController::class,'confirmation'])->name('cart.confirmation');

Route::get('/contact-us',[HomeController::class,'contact'])->name('home.contact');
Route::post('/contact/store',[HomeController::class,'contact_store'])->name('home.contact.store');

// Route::get('/about-us', function () {
//     return view('about-us'); 
// })->name('about.us');

Route::get('/privacy-policy', function () {
    return view('privacy-policy'); 
})->name('privacy.policy');

Route::get('/terms-condition', function () {
    return view('terms-condition'); 
})->name('terms.condition');

Route::get('/return-policy', function () {
    return view('return'); 
})->name('return.policy');



// Route::put('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');


Route::get('/search',[HomeController::class,'search'])->name('home.search');



    Route::get('/account-dashboard',[UserController::class,'index'])->name('user.index');
    Route::get('/account-orders',[UserController::class,'orders'])->name('user.orders');
    Route::get('/account-order/{order_id}/details',[UserController::class,'order_details'])->name('user.order.details');
    Route::put('/account-order/cancel-order',[UserController::class,'account_cancel_order'])->name('user.account_cancel_order');

Route::middleware(['auth',AuthAdmin::class])->group(function(){
    //Brand
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
    Route::get('/admin/brands',[AdminController::class,'brands'])->name('admin.brands');
    Route::get('/admin/brand/add',[AdminController::class,'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store',[AdminController::class,'add_brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/{id}/edit',[AdminController::class,'edit_brand'])->name('admin.brand.edit');
    Route::put('/admin/brand/update',[AdminController::class,'update_brand'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete',[AdminController::class,'delete_brand'])->name('admin.brand.delete');

    // Category
    Route::get('/admin/categories',[AdminController::class,'categories'])->name('admin.categories');
    Route::get('/admin/category/add',[AdminController::class,'add_category'])->name('admin.category.add');
    Route::post('/admin/category/store',[AdminController::class,'add_category_store'])->name('admin.category.store');
    Route::get('/admin/category/{id}/edit',[AdminController::class,'edit_category'])->name('admin.category.edit');
    Route::put('/admin/category/update',[AdminController::class,'update_category'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete',[AdminController::class,'delete_category'])->name('admin.category.delete');
    Route::post('/admin/category/{categoryId}/subcategory/store', [CategoryController::class, 'storeSubcategory'])->name('admin.category.subcategory.store');

    //Products
    Route::get('/admin/products',[AdminController::class,'products'])->name('admin.products');
    Route::get('/admin/product/add',[AdminController::class,'add_product'])->name('admin.product.add');
    Route::post('/admin/product/store',[AdminController::class,'product_store'])->name('admin.product.store');
    Route::get('/admin/product/{id}/edit',[AdminController::class,'edit_product'])->name('admin.product.edit');
    Route::put('/admin/product/update',[AdminController::class,'update_product'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete',[AdminController::class,'delete_product'])->name('admin.product.delete');

    //Coupon
    Route::get('/admin/coupons',[AdminController::class,'coupons'])->name('admin.coupons');
    Route::get('/admin/coupon/add',[AdminController::class,'add_coupon'])->name('admin.coupon.add');
    Route::post('/admin/coupon/store',[AdminController::class,'add_coupon_store'])->name('admin.coupon.store');
    Route::get('/admin/coupon/{id}/edit',[AdminController::class,'edit_coupon'])->name('admin.coupon.edit');
    Route::put('/admin/coupon/update',[AdminController::class,'update_coupon'])->name('admin.coupon.update');
    Route::delete('/admin/coupon/{id}/delete',[AdminController::class,'delete_coupon'])->name('admin.coupon.delete');

    //Admin Show order
    Route::get('/admin/orders',[AdminController::class,'orders'])->name('admin.orders');
    Route::get('/admin/order/items/{order_id}',[AdminController::class,'order_items'])->name('admin.order.items');
    Route::put('/admin/order/update-status',[AdminController::class,'update_order_status'])->name('admin.order.status.update');

    Route::get('/admin/slides',[AdminController::class,'slides'])->name('admin.slides');
    Route::get('/admin/slide/add',[AdminController::class,'slide_add'])->name('admin.slide.add');
    Route::post('/admin/slide/store',[AdminController::class,'slide_store'])->name('admin.slide.store');
    Route::get('/admin/slide/{id}/edit',[AdminController::class,'slide_edit'])->name('admin.slide.edit');
    Route::put('/admin/slide/update',[AdminController::class,'slide_update'])->name('admin.slide.update');
    Route::Delete('/admin/slide/{id}/delete',[AdminController::class,'slide_delete'])->name('admin.slide.delete');

    //contact
    Route::get('admin/contact',[AdminController::class,'contacts'])->name('admin.contacts');
    Route::delete('admin/contact/{id}/delete',[AdminController::class,'contact_delete'])->name('admin.contact.delete');

    //search
    Route::get('/admin/search',[AdminController::class,'search'])->name('admin.search');
    Route::get('/admin/getSubcategories/{category_id}', [AdminController::class, 'getSubcategories'])->name('admin.getSubcategories');

    Route::get('/admin/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::put('/admin/reviews/{id}/approve', [AdminController::class, 'approve_review'])->name('admin.approve.review');
    Route::delete('/admin/reviews/{id}', [AdminController::class, 'delete_review'])->name('admin.delete.review');


});
//reviews

Route::post('/products/{productId}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
