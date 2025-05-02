<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use App\Models\Sizes;
use App\Models\OrderItem;
use App\Models\Product_Variations;
use App\Models\Product;
use App\Models\Transaction;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index()
    {
        try {
            $cartItems = Cart::instance('cart')->content();
            
            // Calculate cart totals
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $shippingCost = ($cartSubtotal > 6999) ? 0 : 250;
            $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $tax = (float) str_replace(',', '', Cart::instance('cart')->tax());
            $total = (float) str_replace(',', '', Cart::instance('cart')->total());
            $finalTotal = $total + $shippingCost;

            // Log for debugging
            Log::info('Cart Index Totals:', [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shippingCost' => $shippingCost,
                'finalTotal' => $finalTotal,
            ]);

            return view('cart', compact('cartItems', 'subtotal', 'tax', 'shippingCost', 'finalTotal'));
        } catch (\Exception $e) {
            Log::error('Cart index error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('home')->with('error', 'Unable to load cart.');
        }
    }

    /**
     * Add a product to the cart.
     */
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'size_id' => 'required|integer|exists:sizes,id',
                'name' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
            ]);
    
            $product = Product::findOrFail($request->id);
            $size = Sizes::findOrFail($request->size_id);
    
            // Check stock in product variations
            $variation = $product->productVariations()->where('size_id', $request->size_id)->first();
            if (!$variation || $variation->quantity < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested quantity not available'
                ], 400);
            }
    
            Cart::instance('cart')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->quantity, // Use 'qty' instead of 'quantity'
                'price' => $product->sale_price ?: $product->regular_price,
                'options' => ['size' => $size->name]
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    /**
     * Check quantity of a product/size in the cart.
     */
    public function checkQuantity(Request $request)
    {
        try {
            $productId = $request->query('product_id');
            $sizeId = $request->query('size_id');
    
            if (!is_numeric($productId) || !is_numeric($sizeId)) {
                return response()->json(['cartQuantity' => 0], 400);
            }
    
            $size = Sizes::findOrFail($sizeId); // Get the size name
            $cartQuantity = Cart::instance('cart')->content()
                ->where('id', (int)$productId)
                ->where('options.size', $size->name) // Use options.size
                ->sum('qty');
    
            return response()->json(['cartQuantity' => $cartQuantity]);
        } catch (\Exception $e) {
            Log::error('checkQuantity error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['cartQuantity' => 0], 500);
        }
    }

    /**
     * Increase the quantity of a cart item.
     */
    public function increase_item_quantity(Request $request, $rowId)
    {
        try {
            $cartItem = Cart::instance('cart')->get($rowId);
            if (!$cartItem) {
                return $request->ajax()
                    ? response()->json(['success' => false, 'message' => 'Cart item not found.'], 404)
                    : redirect()->back()->with('error', 'Cart item not found.');
            }
    
            $availableQuantity = isset($cartItem->options->available_quantity)
                ? (int)$cartItem->options->available_quantity
                : PHP_INT_MAX;
            $globalQuantity = isset($cartItem->options->global_quantity)
                ? (int)$cartItem->options->global_quantity
                : PHP_INT_MAX;
            $allowedMax = min($availableQuantity, $globalQuantity);
    
            $newQuantity = $cartItem->qty + 1;
            if ($newQuantity > $allowedMax) {
                return $request->ajax()
                    ? response()->json(['success' => false, 'message' => "Only $allowedMax items available."], 422)
                    : redirect()->back()->with('error', "Only $allowedMax items available.");
            }
    
            Cart::instance('cart')->update($rowId, $newQuantity);
            $this->calculateDiscounts();
    
            $updatedCartItem = Cart::instance('cart')->get($rowId);
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $shippingCost = ($cartSubtotal > 7000) ? 0 : 250;

            $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $tax = (float) str_replace(',', '', Cart::instance('cart')->tax());
            $total = (float) str_replace(',', '', Cart::instance('cart')->total());
            $finalTotal = $total + $shippingCost;

            $totals = view('partials.cart-totals', compact('shippingCost', 'subtotal', 'tax', 'finalTotal'))->render();

            if ($request->ajax()) {
                $cartItems = Cart::instance('cart')->content();
                $content = view('partials.cart-modal-content', compact('cartItems'))->render();
                return response()->json([
                    'success' => true,
                    'newQuantity' => $updatedCartItem->qty,
                    'subtotal' => $updatedCartItem->price * $updatedCartItem->qty,
                    'totals' => $totals,
                    'content' => $content,
                ]);
            }
    
            return redirect()->back()->with('success', 'Quantity increased successfully.');
        } catch (\Exception $e) {
            Log::error('increase_item_quantity error: ' . $e->getMessage(), [
                'rowId' => $rowId,
                'trace' => $e->getTraceAsString(),
            ]);
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'An error occurred while increasing quantity.'], 500)
                : redirect()->back()->with('error', 'An error occurred while increasing quantity.');
        }
    }
    
    /**
     * Reduce the quantity of a cart item.
     */
    public function reduce_item_quantity(Request $request, $rowId)
    {
        try {
            $cartItem = Cart::instance('cart')->get($rowId);
            if (!$cartItem) {
                return $request->ajax()
                    ? response()->json(['success' => false, 'message' => 'Cart item not found.'], 404)
                    : redirect()->back()->with('error', 'Cart item not found.');
            }

            $newQuantity = $cartItem->qty - 1;
            if ($newQuantity < 1) {
                Cart::instance('cart')->remove($rowId);
                $this->calculateDiscounts();
                return $request->ajax()
                    ? response()->json(['success' => true, 'message' => 'Item removed from cart.', 'totals' => $this->getCartTotals()])
                    : redirect()->back()->with('success', 'Item removed from cart.');
            }

            Cart::instance('cart')->update($rowId, $newQuantity);
            $this->calculateDiscounts();

            $updatedCartItem = Cart::instance('cart')->get($rowId);
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $shippingCost = ($cartSubtotal > 6999) ? 0 : 250;

            $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $tax = (float) str_replace(',', '', Cart::instance('cart')->tax());
            $total = (float) str_replace(',', '', Cart::instance('cart')->total());
            $finalTotal = $total + $shippingCost;

            $totals = view('partials.cart-totals', compact('shippingCost', 'subtotal', 'tax', 'finalTotal'))->render();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'newQuantity' => $updatedCartItem->qty,
                    'subtotal' => $updatedCartItem->price * $updatedCartItem->qty,
                    'totals' => $totals,
                ]);
            }

            return redirect()->back()->with('success', 'Quantity reduced successfully.');
        } catch (\Exception $e) {
            Log::error('reduce_item_quantity error: ' . $e->getMessage(), [
                'rowId' => $rowId,
                'trace' => $e->getTraceAsString(),
            ]);
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'An error occurred while reducing quantity.'], 500)
                : redirect()->back()->with('error', 'An error occurred while reducing quantity.');
        }
    }

    /**
     * Remove an item from the cart.
     */
    public function remove_item_from_cart($rowId)
    {
        try {
            Cart::instance('cart')->remove($rowId);
            $this->calculateDiscounts();
            return redirect()->back()->with('success', 'Item removed from cart.');
        } catch (\Exception $e) {
            Log::error('remove_item_from_cart error: ' . $e->getMessage(), [
                'rowId' => $rowId,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'An error occurred while removing item.');
        }
    }

    /**
     * Get the cart item count.
     */
    public function getCartCount()
    {
        return response()->json([
            'count' => Cart::instance('cart')->content()->count()
        ]);
    }
    /**
     * Clear the entire cart.
     */
    public function empty(Request $request)
    {
        try {
            Cart::instance('cart')->destroy();
            session()->forget(['coupon', 'discounts', 'checkout']);
    
            if ($request->ajax()) {
                $cartItems = Cart::instance('cart')->content();
                $content = view('partials.cart-modal-content', compact('cartItems'))->render();
                return response()->json([
                    'success' => true,
                    'content' => $content,
                ]);
            }
    
            return redirect()->back()->with('success', 'Cart cleared successfully.');
        } catch (\Exception $e) {
            Log::error('empty_cart error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->errorResponse($request, 'An error occurred while clearing cart.', 500);
        }
    }

    /**
     * Apply a coupon code.
     */
    public function applyCoupon(Request $request)
    {
        try {
            $request->validate([
                'coupon_code' => 'required|string',
            ]);

            $coupon_code = $request->coupon_code;
            $cartSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
            $coupon = Coupon::where('code', $coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', $cartSubtotal)
                ->first();

            if (!$coupon) {
                session()->forget('coupon');
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Invalid coupon code.'], 422);
                }
                return back()->with('error', 'Invalid coupon code.');
            }

            session()->put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value,
            ]);

            $this->calculateDiscounts();
            return back()->with('status', 'Coupon code applied successfully!');
        } catch (\Exception $e) {
            Log::error('apply_coupon_code error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'An error occurred while applying coupon.');
        }
    }

    /**
     * Calculate discounts based on applied coupon.
     */
    public function calculateDiscounts()
    {
        try {
            $discount = 0;
            if (session()->has('coupon')) {
                $subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
                $couponValue = floatval(session()->get('coupon')['value']);
                $couponType = session()->get('coupon')['type'];
                $cartValue = floatval(session()->get('coupon')['cart_value']);

                if ($subtotal >= $cartValue) {
                    if ($couponType == 'fixed') {
                        $discount = $couponValue;
                    } else {
                        $discount = ($subtotal * $couponValue) / 100;
                    }

                    $subtotalAfterDiscount = $subtotal - $discount;
                    $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
                    $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

                    session()->put('discounts', [
                        'discount' => number_format($discount, 2, '.', ''),
                        'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
                        'tax' => number_format($taxAfterDiscount, 2, '.', ''),
                        'total' => number_format($totalAfterDiscount, 2, '.', '')
                    ]);
                } else {
                    session()->forget('coupon');
                    session()->forget('discounts');
                }
            }
        } catch (\Exception $e) {
            Log::error('calculateDiscounts error: ' . $e->getMessage());
            session()->forget('coupon');
            session()->forget('discounts');
        }
    }

    /**
     * Set checkout amounts.
     */
    public function setAmountForCheckout()
    {
        try {
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $shippingCost = ($cartSubtotal > 6999) ? 0 : 250;

            if (Cart::instance('cart')->count() > 0) {
                if (session()->has('coupon')) {
                    $discountTotal = (float) str_replace(',', '', session()->get('discounts')['total']);
                    $finalTotal = $discountTotal + $shippingCost;
                    session()->put('checkout', [
                        'discount' => session()->get('discounts')['discount'],
                        'subtotal' => session()->get('discounts')['subtotal'],
                        'tax' => session()->get('discounts')['tax'],
                        'total' => number_format($finalTotal, 2, '.', '')
                    ]);
                } else {
                    $cartTotal = (float) str_replace(',', '', Cart::instance('cart')->total());
                    $finalTotal = $cartTotal + $shippingCost;
                    session()->put('checkout', [
                        'discount' => 0,
                        'subtotal' => Cart::instance('cart')->subtotal(),
                        'tax' => Cart::instance('cart')->tax(),
                        'total' => number_format($finalTotal, 2, '.', '')
                    ]);
                }
            } else {
                session()->forget('checkout');
            }
        } catch (\Exception $e) {
            Log::error('setAmountForCheckout error: ' . $e->getMessage());
            session()->forget('checkout');
        }
    }

    /**
     * Remove applied coupon.
     */
    public function remove_coupon_code()
    {
        try {
            session()->forget('coupon');
            session()->forget('discounts');
            return back()->with('status', 'Coupon removed successfully!');
        } catch (\Exception $e) {
            Log::error('remove_coupon_code error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while removing coupon.');
        }
    }

    /**
     * Display the checkout page.
     */
    public function checkout()
    {
        try {
            $address = session()->get('address', null);
            
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $shippingCost = ($cartSubtotal > 6999) ? 0 : 250;
            $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $tax = (float) str_replace(',', '', Cart::instance('cart')->tax());
            $total = (float) str_replace(',', '', Cart::instance('cart')->total());
            $finalTotal = $total + $shippingCost;

            Log::info('Checkout Cart Totals:', [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shippingCost' => $shippingCost,
                'finalTotal' => $finalTotal,
            ]);

            return view('checkout', compact('address', 'subtotal', 'tax', 'shippingCost', 'finalTotal'));
        } catch (\Exception $e) {
            Log::error('checkout error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('cart.index')->with('error', 'Unable to load checkout.');
        }
    }

    /**
     * Place an order.
     */
    public function place_order(Request $request)
    {
        try {
            Log::info('Place Order Request Data:', $request->all());

            // Check if cart is empty
            $cartItems = Cart::instance('cart')->content();
            if ($cartItems->isEmpty()) {
                Log::warning('Cart is empty during place_order');
                return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items to proceed.');
            }

            // Check for saved address
            $address = session()->get('address', null);
            $validationRules = [
                'mode' => 'required|in:card,paypal,cod',
            ];

            // Only validate input fields if no saved address is provided
            if (!$address) {
                $validationRules = array_merge($validationRules, [
                    'email' => 'required|email|max:255',
                    'name' => 'required|string|max:100',
                    'phone' => 'required|string|min:10|max:15',
                    'zip' => 'required|string|min:5|max:10',
                    'state' => 'required|string|max:100',
                    'city' => 'required|string|max:100',
                    'address' => 'required|string|max:255',
                    'locality' => 'required|string|max:255',
                ]);
            }

            $request->validate($validationRules, [
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'name.required' => 'Full name is required.',
                'phone.required' => 'Phone number is required.',
                'phone.min' => 'Phone number must be at least 10 characters.',
                'zip.required' => 'Postal code is required.',
                'zip.min' => 'Postal code must be at least 5 characters.',
                'state.required' => 'State is required.',
                'city.required' => 'City is required.',
                'address.required' => 'Address is required.',
                'locality.required' => 'Locality is required.',
                'mode.required' => 'Please select a payment method.',
                'mode.in' => 'Invalid payment method selected.',
            ]);

            Log::info('Cart Items:', ['count' => $cartItems->count(), 'items' => $cartItems->toArray()]);

            // Set checkout amounts
            $this->setAmountForCheckout();
            $checkout = session()->get('checkout');

            if (!$checkout) {
                Log::warning('Checkout session data missing');
                return redirect()->route('cart.checkout')->with('error', 'Checkout data is missing. Please try again.');
            }

            $subtotal = (float) str_replace(',', '', $checkout['subtotal']);
            $discount = (float) str_replace(',', '', $checkout['discount']);
            $tax = (float) str_replace(',', '', $checkout['tax']);
            $total = (float) str_replace(',', '', $checkout['total']);

            // Verify stock for each item
            foreach ($cartItems as $item) {
                $product = Product::find($item->id);
                if (!$product) {
                    Log::warning('Product not found', ['product_id' => $item->id]);
                    return redirect()->route('cart.checkout')->with('error', "Product not found: {$item->name}.");
                }

                // Find size_id from size name in options
                $size = Sizes::where('name', $item->options->size)->first();
                if (!$size) {
                    Log::warning('Size not found', ['size_name' => $item->options->size]);
                    return redirect()->route('cart.checkout')->with('error', "Size not found for {$item->name}.");
                }

                $productVariation = Product_Variations::where('product_id', $item->id)
                    ->where('size_id', $size->id)
                    ->first();
                if (!$productVariation || $productVariation->quantity < $item->qty) {
                    Log::warning('Product variation out of stock', [
                        'product_id' => $item->id,
                        'size_id' => $size->id,
                        'requested_qty' => $item->qty,
                        'available_qty' => $productVariation ? $productVariation->quantity : 0,
                    ]);
                    return redirect()->route('cart.checkout')->with('error', "Sorry, the selected size for {$item->name} is out of stock.");
                }

                if ($product->quantity < $item->qty) {
                    Log::warning('Product out of stock', [
                        'product_id' => $item->id,
                        'requested_qty' => $item->qty,
                        'available_qty' => $product->quantity,
                    ]);
                    return redirect()->route('cart.checkout')->with('error', "Sorry, only {$product->quantity} items of {$item->name} are available in stock.");
                }
            }

            // Calculate shipping cost
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $shippingCost = ($cartSubtotal > 6999) ? 0 : 250;

            // Create order
            $order = new Order();
            $order->email = $address ? $address->email : $request->email;
            $order->subtotal = $subtotal;
            $order->discount = $discount;
            $order->tax = $tax;
            $order->total = $total;
            $order->shipping_cost = $shippingCost;
            $order->name = $address ? $address->name : $request->name;
            $order->phone = $address ? $address->phone : $request->phone;
            $order->locality = $address ? $address->locality : $request->locality;
            $order->address = $address ? $address->address : $request->address;
            $order->city = $address ? $address->city : $request->city;
            $order->state = $address ? $address->state : $request->state;
            $order->country = $address ? $address->country : 'N/A';
            $order->zip = $address ? $address->zip : $request->zip;
            $order->save();

            // Create order items and update stock
            foreach ($cartItems as $item) {
                $product = Product::find($item->id);
                $size = Sizes::where('name', $item->options->size)->first();
                $productVariation = Product_Variations::where('product_id', $item->id)
                    ->where('size_id', $size->id)
                    ->first();

                if ($productVariation) {
                    $productVariation->quantity -= $item->qty;
                    $productVariation->save();
                }

                $product->quantity -= $item->qty;
                $product->save();

                $orderItem = new OrderItem();
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->price = $item->price;
                $orderItem->quantity = $item->qty;
                $orderItem->product_variation_id = $productVariation ? $productVariation->id : null;
                $orderItem->save();
            }

            // Handle COD transaction
            if ($request->mode === 'cod') {
                $transaction = new Transaction();
                $transaction->order_id = $order->id;
                $transaction->mode = 'cod';
                $transaction->status = 'pending';
                $transaction->save();
            }

            // Clear cart and session
            Cart::instance('cart')->destroy();
            session()->forget(['checkout', 'coupon', 'discounts']);
            session()->put('order_id', $order->id);

            // Send confirmation email
            try {
                Mail::to($order->email)->send(new OrderConfirmation($order));
                Log::info('Order confirmation email sent', ['order_id' => $order->id, 'email' => $order->email]);
            } catch (\Exception $e) {
                Log::error('Error sending email: ' . $e->getMessage(), ['order_id' => $order->id]);
                // Continue to confirmation even if email fails
            }

            Log::info('Order placed successfully', ['order_id' => $order->id]);
            return redirect()->route('cart.confirmation')->with('success', 'Order placed successfully!')->with('order_id', $order->id);
        } catch (\Exception $e) {
            Log::error('place_order error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('cart.checkout')->with('error', 'Order could not be placed: ' . $e->getMessage());
        }
    }

    /**
     * Display order confirmation.
     */
    public function confirmation()
    {
        try {
            if (session()->has('order_id')) {
                $order = Order::find(session()->get('order_id'));
                if (!$order) {
                    return redirect()->route('cart.index')->with('error', 'Order not found.');
                }
                return view('order-confirmation', compact('order'));
            }
            return redirect()->route('cart.index')->with('error', 'No order found.');
        } catch (\Exception $e) {
            Log::error('confirmation error: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Unable to load order confirmation.');
        }
    }

    /**
     * Get cart totals for AJAX updates.
     */
    private function getCartTotals()
    {
        $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $shippingCost = ($cartSubtotal > 7000) ? 0 : 250;
        $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $tax = (float) str_replace(',', '', Cart::instance('cart')->tax());
        $total = (float) str_replace(',', '', Cart::instance('cart')->total());
        $finalTotal = $total + $shippingCost;
        return view('partials.cart-totals', compact('shippingCost', 'subtotal', 'tax', 'finalTotal'))->render();
    }

    /**
     * Get cart partial view for modal.
     */
    public function getCartPartial()
    {
        try {
            $cartItems = Cart::instance('cart')->content();
            return view('partials.cart-modal-content', compact('cartItems'));
        } catch (\Exception $e) {
            Log::error('getCartPartial error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Unable to load cart content'], 500);
        }
    }

    /**
     * Update cart item quantity via AJAX.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'rowId' => 'required',
                'quantity' => 'required|integer|min:1',
            ]);

            $cartItem = Cart::instance('cart')->get($request->rowId);
            if (!$cartItem) {
                return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
            }

            $availableQuantity = isset($cartItem->options->available_quantity)
                ? (int)$cartItem->options->available_quantity
                : PHP_INT_MAX;
            $globalQuantity = isset($cartItem->options->global_quantity)
                ? (int)$cartItem->options->global_quantity
                : PHP_INT_MAX;
            $allowedMax = min($availableQuantity, $globalQuantity);

            if ($request->quantity > $allowedMax) {
                return response()->json(['success' => false, 'message' => "Only $allowedMax items available."], 422);
            }

            Cart::instance('cart')->update($request->rowId, $request->quantity);
            $this->calculateDiscounts();

            $cartItems = Cart::instance('cart')->content();
            $content = view('partials.cart-modal-content', compact('cartItems'))->render();
            return response()->json([
                'success' => true,
                'content' => $content,
            ]);
        } catch (\Exception $e) {
            Log::error('update error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'An error occurred while updating quantity.'], 500);
        }
    }

    /**
     * Remove a cart item via AJAX.
     */
    public function remove(Request $request)
    {
        try {
            $request->validate(['rowId' => 'required']);
            Cart::instance('cart')->remove($request->rowId);
            $this->calculateDiscounts();

            $cartItems = Cart::instance('cart')->content();
            $content = view('partials.cart-modal-content', compact('cartItems'))->render();
            return response()->json([
                'success' => true,
                'content' => $content,
            ]);
        } catch (\Exception $e) {
            Log::error('remove error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'An error occurred while removing item.'], 500);
        }
    }

    /**
     * Clear the cart via AJAX.
     */
    public function clear(Request $request)
    {
        try {
            Cart::instance('cart')->destroy();
            session()->forget(['coupon', 'discounts', 'checkout']);

            $cartItems = Cart::instance('cart')->content();
            $content = view('partials.cart-modal-content', compact('cartItems'))->render();
            return response()->json([
                'success' => true,
                'content' => $content,
            ]);
        } catch (\Exception $e) {
            Log::error('clear error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'An error occurred while clearing cart.'], 500);
        }
    }

    /**
     * Handle error responses.
     */
    private function errorResponse(Request $request, $message, $status)
    {
        return $request->ajax()
            ? response()->json(['success' => false, 'message' => $message], $status)
            : redirect()->back()->with('error', $message);
    }
}