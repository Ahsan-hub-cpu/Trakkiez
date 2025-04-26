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
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:products,id',
                'name' => 'required|string',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'size_id' => 'required|integer|exists:sizes,id',
            ]);

            $productId = $request->id;
            $sizeId = $request->size_id;
            $quantity = $request->quantity;

            $size = Sizes::find($sizeId);
            if (!$size) {
                return $request->ajax()
                    ? response()->json(['success' => false, 'message' => 'Invalid size selection.'], 422)
                    : redirect()->back()->with('error', 'Invalid size selection.');
            }

            $productVariation = Product_Variations::where('product_id', $productId)
                ->where('size_id', $sizeId)
                ->first();
            if (!$productVariation) {
                return $request->ajax()
                    ? response()->json(['success' => false, 'message' => 'Product variation not found.'], 422)
                    : redirect()->back()->with('error', 'Product variation not found.');
            }

            if ($quantity > $productVariation->quantity) {
                return $request->ajax()
                    ? response()->json(['success' => false, 'message' => 'Only ' . $productVariation->quantity . ' items available in this size.'], 422)
                    : redirect()->back()->with('error', 'Only ' . $productVariation->quantity . ' items available in this size.');
            }

            $product = Product::find($productId);
            if (!$product) {
                return $request->ajax()
                    ? response()->json(['success' => false, 'message' => 'Product not found.'], 422)
                    : redirect()->back()->with('error', 'Product not found.');
            }
            if ($quantity > $product->quantity) {
                return $request->ajax()
                    ? response()->json(['success' => false, 'message' => 'Only ' . $product->quantity . ' items in stock.'], 422)
                    : redirect()->back()->with('error', 'Only ' . $product->quantity . ' items in stock.');
            }

            $cartItem = Cart::instance('cart')->content()->where('id', $productId)
                ->where('options.size_id', $sizeId)
                ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->qty + $quantity;
                if ($newQuantity > $productVariation->quantity) {
                    return $request->ajax()
                        ? response()->json(['success' => false, 'message' => 'Cannot add more than ' . $productVariation->quantity . ' items in this size.'], 422)
                        : redirect()->back()->with('error', 'Cannot add more than ' . $productVariation->quantity . ' items in this size.');
                }
                if ($newQuantity > $product->quantity) {
                    return $request->ajax()
                        ? response()->json(['success' => false, 'message' => 'Cannot add more than ' . $product->quantity . ' items in stock.'], 422)
                        : redirect()->back()->with('error', 'Cannot add more than ' . $product->quantity . ' items in stock.');
                }
                Cart::instance('cart')->update($cartItem->rowId, $newQuantity);
            } else {
                Cart::instance('cart')->add(
                    $productId,
                    $request->name,
                    $quantity,
                    $request->price,
                    [
                        'size' => $size->name,
                        'size_id' => $size->id,
                        'product_variation_id' => $productVariation->id,
                        'available_quantity' => $productVariation->quantity,
                        'global_quantity' => $product->quantity,
                    ]
                )->associate('App\Models\Product');
            }

            $cartQuantity = Cart::instance('cart')->content()
                ->where('id', $productId)
                ->where('options.size_id', $sizeId)
                ->sum('qty');

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'cartQuantity' => $cartQuantity,
                    'message' => 'Product added to cart successfully',
                ]);
            }

            return redirect()->back()->with('success', 'Product added to cart!');
        } catch (\Exception $e) {
            Log::error('addToCart error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'An error occurred while adding to cart.'], 500)
                : redirect()->back()->with('error', 'An error occurred while adding to cart.');
        }
    }

    public function checkQuantity(Request $request)
    {
        try {
            $productId = $request->query('product_id');
            $sizeId = $request->query('size_id');

            if (!is_numeric($productId) || !is_numeric($sizeId)) {
                return response()->json(['cartQuantity' => 0], 400);
            }

            $cartQuantity = Cart::instance('cart')->content()
                ->where('id', (int)$productId)
                ->where('options.size_id', (int)$sizeId)
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
                return response()->json([
                    'success' => true,
                    'newQuantity' => $updatedCartItem->qty,
                    'subtotal' => $updatedCartItem->price * $updatedCartItem->qty,
                    'totals' => $totals,
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

    public function empty_cart()
    {
        try {
            Cart::instance('cart')->destroy();
            session()->forget(['coupon', 'discounts', 'checkout']);
            return redirect()->back()->with('success', 'Cart cleared successfully.');
        } catch (\Exception $e) {
            Log::error('empty_cart error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'An error occurred while clearing cart.');
        }
    }

    public function apply_coupon_code(Request $request)
    {
        try {
            $coupon_code = $request->coupon_code;
            if (!$coupon_code) {
                return back()->with('error', 'Coupon code is required.');
            }

            $cartSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
            $coupon = Coupon::where('code', $coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', $cartSubtotal)
                ->first();

            if (!$coupon) {
                session()->forget('coupon');
                return back()->with('error', 'Invalid coupon code.');
            }

            session()->put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value
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

  public function checkout()
{
    try {
        $address = session()->get('address', null);
        
        // Calculate cart totals
        $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $shippingCost = ($cartSubtotal > 6999) ? 0 : 250;
        $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $tax = (float) str_replace(',', '', Cart::instance('cart')->tax());
        $total = (float) str_replace(',', '', Cart::instance('cart')->total());
        $finalTotal = $total + $shippingCost;

        // Log for debugging
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

  public function place_order(Request $request)
{
    try {
        // Log request data for debugging
        Log::info('Place Order Request Data:', $request->all());

        // Validate request with relaxed rules
        $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:100',
            'phone' => 'required|string|min:10|max:15', // Allow 10-15 characters
            'zip' => 'required|string|min:5|max:10', // Allow 5-10 characters
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'mode' => 'required|in:card,paypal,cod',
        ], [
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

        // Check cart contents
        $cartItems = Cart::instance('cart')->content();
        Log::info('Cart Items:', ['count' => $cartItems->count(), 'items' => $cartItems->toArray()]);

        if ($cartItems->isEmpty()) {
            Log::warning('Cart is empty during place_order');
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items to proceed.');
        }

        // Set checkout amounts
        $this->setAmountForCheckout();
        $checkout = session()->get('checkout');

        if (!$checkout) {
            Log::warning('Checkout session data missing');
            return redirect()->route('cart.index')->with('error', 'Checkout data is missing. Please try again.');
        }

        $subtotal = (float) str_replace(',', '', $checkout['subtotal']);
        $discount = (float) str_replace(',', '', $checkout['discount']);
        $tax = (float) str_replace(',', '', $checkout['tax']);
        $total = (float) str_replace(',', '', $checkout['total']);

        // Verify product and variation stock
        foreach ($cartItems as $item) {
            $product = Product::find($item->id);
            if (!$product) {
                Log::warning('Product not found', ['product_id' => $item->id]);
                return back()->with('error', "Product not found.");
            }

            $productVariation = Product_Variations::where('product_id', $item->id)
                ->where('size_id', $item->options->size_id)
                ->first();
            if (!$productVariation || $productVariation->quantity < $item->qty) {
                Log::warning('Product variation out of stock', [
                    'product_id' => $item->id,
                    'size_id' => $item->options->size_id,
                    'requested_qty' => $item->qty,
                    'available_qty' => $productVariation ? $productVariation->quantity : 0,
                ]);
                return back()->with('error', "Sorry, the selected size is out of stock.");
            }

            if ($product->quantity < $item->qty) {
                Log::warning('Product out of stock', [
                    'product_id' => $item->id,
                    'requested_qty' => $item->qty,
                    'available_qty' => $product->quantity,
                ]);
                return back()->with('error', "Sorry, only " . $product->quantity . " items are available in stock.");
            }
        }

        $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $shippingCost = ($cartSubtotal > 6999) ? 0 : 250;

        // Create order
        $order = new Order();
        $order->email = $request->email;
        $order->subtotal = $subtotal;
        $order->discount = $discount;
        $order->tax = $tax;
        $order->total = $total;
        $order->shipping_cost = $shippingCost;
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->locality = $request->locality;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->state = $request->state;
        $order->country = 'N/A';
        $order->zip = $request->zip;
        $order->save();

        // Create order items and update stock
        foreach ($cartItems as $item) {
            $product = Product::find($item->id);
            $productVariation = Product_Variations::where('product_id', $item->id)
                ->where('size_id', $item->options->size_id)
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
            $orderItem->product_variation_id = $item->options->product_variation_id ?? null;
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
            Mail::to($request->email)->send(new OrderConfirmation($order));
            Log::info('Order confirmation email sent', ['order_id' => $order->id, 'email' => $request->email]);
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage(), ['order_id' => $order->id]);
            return redirect()->route('cart.confirmation')->with('error', 'Issue sending confirmation email.');
        }

        Log::info('Order placed successfully', ['order_id' => $order->id]);
        return redirect()->route('cart.confirmation')->with('order_id', $order->id);
    } catch (\Exception $e) {
        Log::error('place_order error: ' . $e->getMessage(), [
            'request' => $request->all(),
            'trace' => $e->getTraceAsString(),
        ]);
        return back()->with('error', 'Order could not be placed. Please try again.');
    }
}

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
}