<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Sizes;
use App\Models\OrderItem;
use App\Models\Product_Variations;
use App\Models\Product;
use App\Models\Transaction;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $shippingCost = ($cartSubtotal > 5999) ? 0 : 250;
            $subtotal = $cartSubtotal;
            $tax = (float) str_replace(',', '', Cart::instance('cart')->tax());
            $total = (float) str_replace(',', '', Cart::instance('cart')->total());
            $finalTotal = $total + $shippingCost;

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
    
            $product = Product::with(['productVariations' => function ($query) use ($request) {
                $query->where('size_id', $request->size_id);
            }])->findOrFail($request->id);
    
            $size = Sizes::findOrFail($request->size_id);
            $variation = $product->productVariations->first();
    
            if (!$variation || $variation->quantity < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested quantity not available'
                ], 422);
            }
    
            $cartItem = Cart::instance('cart')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->quantity,
                'price' => $product->sale_price ?: $product->regular_price,
                'options' => [
                    'size' => $size->name,
                    'size_id' => $size->id,
                    'image' => $product->image,
                    'slug' => $product->slug,
                ],
            ]);
    
            $cartItem->associate(Product::class);
    
            $cartItems = Cart::instance('cart')->content()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->qty,
                    'options' => $item->options->toArray()
                ];
            })->values()->all();
            $content = view('partials.cart-modal-content', compact('cartItems'))->render();
    
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart',
                'content' => $content,
                'count' => Cart::instance('cart')->content()->count(),
                'cartItems' => $cartItems // Added to return all cart items
            ]);
        } catch (\Exception $e) {
            Log::error('addToCart error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding to cart'
            ], 500);
        }
    }


    /**
     * Check quantity of a product/size in the cart.
     */
    public function checkQuantity(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'size_id' => 'required|integer|exists:sizes,id',
            ]);

            $size = Sizes::findOrFail($request->size_id);
            $cartQuantity = Cart::instance('cart')->content()
                ->where('id', $request->product_id)
                ->where('options.size', $size->name)
                ->sum('qty');

            return response()->json(['cartQuantity' => $cartQuantity]);
        } catch (\Exception $e) {
            Log::error('checkQuantity error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['cartQuantity' => 0], 500);
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

            $size = Sizes::where('name', $cartItem->options->size)->first();
            if (!$size) {
                return response()->json(['success' => false, 'message' => 'Size not found.'], 400);
            }

            $variation = Product_Variations::where('product_id', $cartItem->id)
                ->where('size_id', $size->id)
                ->first();
            if (!$variation || $variation->quantity < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested quantity not available.'
                ], 422);
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
     * Get the cart item count.
     */
    public function getCartCount()
    {
        try {
            return response()->json([
                'count' => Cart::instance('cart')->content()->count()
            ]);
        } catch (\Exception $e) {
            Log::error('getCartCount error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['count' => 0], 500);
        }
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
     * Apply a coupon code.
     */
    public function applyCoupon(Request $request)
    {
        try {
            $request->validate([
                'coupon_code' => 'required|string',
            ]);

            $coupon_code = $request->coupon_code;
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $coupon = Coupon::where('code', $coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', $cartSubtotal)
                ->first();

            if (!$coupon) {
                session()->forget('coupon');
                return response()->json(['success' => false, 'message' => 'Invalid coupon code.'], 422);
            }

            session()->put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value,
            ]);

            $this->calculateDiscounts();

            $cartItems = Cart::instance('cart')->content();
            $content = view('partials.cart-modal-content', compact('cartItems'))->render();

            return response()->json([
                'success' => true,
                'content' => $content,
                'message' => 'Coupon applied successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('applyCoupon error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'An error occurred while applying coupon.'], 500);
        }
    }

    /**
     * Remove applied coupon.
     */
    public function removeCoupon(Request $request)
    {
        try {
            session()->forget('coupon');
            session()->forget('discounts');
            $this->calculateDiscounts();

            $cartItems = Cart::instance('cart')->content();
            $content = view('partials.cart-modal-content', compact('cartItems'))->render();

            return response()->json([
                'success' => true,
                'content' => $content,
                'message' => 'Coupon removed successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('removeCoupon error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'An error occurred while removing coupon.'], 500);
        }
    }

    /**
     * Calculate discounts based on applied coupon.
     */
    protected function calculateDiscounts()
    {
        try {
            $discount = 0;
            if (session()->has('coupon')) {
                $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
                $coupon = session()->get('coupon');
                $couponValue = (float) $coupon['value'];
                $couponType = $coupon['type'];
                $cartValue = (float) $coupon['cart_value'];

                if ($subtotal >= $cartValue) {
                    $discount = $couponType === 'fixed' ? $couponValue : ($subtotal * $couponValue) / 100;
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
            } else {
                session()->forget('discounts');
            }
        } catch (\Exception $e) {
            Log::error('calculateDiscounts error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->forget('coupon');
            session()->forget('discounts');
        }
    }

    /**
     * Set checkout amounts.
     */
    protected function setAmountForCheckout()
    {
        try {
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $shippingCost = ($cartSubtotal > 5999) ? 0 : 250;

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
            Log::error('setAmountForCheckout error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->forget('checkout');
        }
    }

    /**
     * Display the checkout page.
     */
    public function checkout()
    {
        try {
            $address = session()->get('address');
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $shippingCost = ($cartSubtotal > 5999) ? 0 : 250;
            $subtotal = $cartSubtotal;
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
            // Log form data and address session for debugging
            Log::info('Form data', ['data' => $request->all()]);
            Log::info('Address session', ['address' => session('address')]);

            // Check if cart is empty
            $cartItems = Cart::instance('cart')->content();
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items to proceed.');
            }

            // Define validation rules
            $address = session()->get('address');
            $validationRules = [
                'mode' => 'required|in:card,paypal,cod',
            ];

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

            // Validate the request
            $request->validate($validationRules, [
                'email.required' => 'The email field is required.',
                'email.email' => 'Please enter a valid email address.',
                'name.required' => 'The full name field is required.',
                'phone.required' => 'The phone number field is required.',
                'phone.min' => 'The phone number must be at least 10 characters.',
                'zip.required' => 'The postal code field is required.',
                'zip.min' => 'The postal code must be at least 5 characters.',
                'state.required' => 'The state field is required.',
                'city.required' => 'The city field is required.',
                'address.required' => 'The address field is required.',
                'locality.required' => 'The locality field is required.',
                'mode.required' => 'Please select a payment method.',
                'mode.in' => 'Invalid payment method selected.',
            ]);

            // Calculate checkout amounts
            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            $shippingCost = ($cartSubtotal > 5999) ? 0 : 250;
            $subtotal = $cartSubtotal;
            $discount = session()->has('discounts') ? (float) str_replace(',', '', session('discounts')['discount']) : 0;
            $tax = session()->has('discounts') ? (float) str_replace(',', '', session('discounts')['tax']) : (float) str_replace(',', '', Cart::instance('cart')->tax());
            $total = session()->has('discounts') ? (float) str_replace(',', '', session('discounts')['total']) + $shippingCost : (float) str_replace(',', '', Cart::instance('cart')->total()) + $shippingCost;

            // Validate product stock
            foreach ($cartItems as $item) {
                $product = Product::find($item->id);
                if (!$product) {
                    return redirect()->route('cart.checkout')->with('error', "Product not found: {$item->name}.");
                }

                $size = Sizes::where('name', $item->options->size)->first();
                if (!$size) {
                    return redirect()->route('cart.checkout')->with('error', "Size not found for {$item->name}.");
                }

                $productVariation = Product_Variations::where('product_id', $item->id)
                    ->where('size_id', $size->id)
                    ->first();
                if (!$productVariation || $productVariation->quantity < $item->qty) {
                    return redirect()->route('cart.checkout')->with('error', "Sorry, the selected size for {$item->name} is out of stock.");
                }
            }

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

            // Process order items and update stock
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

            // Handle payment (COD only for now)
            if ($request->mode === 'cod') {
                $transaction = new Transaction();
                $transaction->order_id = $order->id;
                $transaction->mode = 'cod';
                $transaction->status = 'pending';
                $transaction->save();
            }

            // Send order confirmation email
            try {
                Mail::to($order->email)->send(new OrderConfirmation($order));
                Log::info('Order confirmation email sent', ['order_id' => $order->id, 'email' => $order->email]);
            } catch (\Exception $e) {
                Log::error('Error sending email: ' . $e->getMessage(), ['order_id' => $order->id]);
            }

            // Clear cart and session
            Cart::instance('cart')->destroy();
            session()->forget(['checkout', 'coupon', 'discounts']);
            session()->put('order_id', $order->id);

            return redirect()->route('cart.confirmation')->with('success', 'Order placed successfully!')->with('order_id', $order->id);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('placeOrder error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
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
            Log::error('confirmation error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('cart.index')->with('error', 'Unable to load order confirmation.');
        }
    }
}