@php
    $cartSubtotal = (float) str_replace(',', '', \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal());
    $shippingCost = ($cartSubtotal > 6999) ? 0 : 250;
    $subtotal = (float) str_replace(',', '', \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal());
    $tax = (float) str_replace(',', '', \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->tax());
    $total = (float) str_replace(',', '', \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->total());
    $finalTotal = $total + $shippingCost;
@endphp

@if($cartItems->count() > 0)
    <div class="cart-table__wrapper">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td>
                            <div class="shopping-cart__product-item d-flex align-items-center">
                                <img loading="lazy" 
                                     src="{{ asset($cartItem->model && isset($cartItem->model->image) ? 'uploads/products/thumbnails/' . $cartItem->model->image : 'images/placeholder.jpg') }}" 
                                     width="80" height="80" 
                                     alt="{{ $cartItem->name }}" />
                                <div class="ms-3">
                                    <h6>{{ $cartItem->name }}</h6>
                                    <p>Size: {{ strtoupper($cartItem->options['size'] ?? 'N/A') }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="shopping-cart__product-price">PKR {{ number_format((float)$cartItem->price, 2) }}</span>
                        </td>
                        <td>
                            <div class="qty-control position-relative">
                                <input type="number" 
                                       name="quantity" 
                                       value="{{ $cartItem->qty }}" 
                                       min="1" 
                                       readonly
                                       class="qty-control__number text-center cart-qty-input" 
                                       data-row-id="{{ $cartItem->rowId }}"
                                       data-max="{{ $cartItem->options->available_quantity }}"
                                       data-global="{{ $cartItem->options->global_quantity }}">
                                <button class="qty-control__reduce cart-qty-reduce" data-row-id="{{ $cartItem->rowId }}">-</button>
                                <button class="qty-control__increase cart-qty-increase" data-row-id="{{ $cartItem->rowId }}">+</button>
                            </div>
                            <span class="text-danger stock-error" id="stock-error-{{ $cartItem->rowId }}"></span>
                        </td>
                        <td>
    @php
        $rawSubtotal = floatval(preg_replace('/[^\d.]/', '', $cartItem->subtotal()));
    @endphp
    <span class="shopping-cart__subtotal" id="subtotal-{{ $cartItem->rowId }}">
        PKR {{ number_format($rawSubtotal, 2) }}
    </span>
</td>
                        <td>
                            <button class="cart-remove-item btn btn-sm btn-danger" data-row-id="{{ $cartItem->rowId }}">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="cart-table-footer mt-3">
            @if(!Session()->has("coupon"))
                <form class="position-relative bg-body mb-3" method="POST" action="{{ route('cart.applyCoupon') }}" id="apply-coupon-form">
                    @csrf
                    <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit" value="APPLY COUPON">
                </form>
            @else
                <form class="position-relative bg-body mb-3" method="POST" action="{{ route('cart.removeCoupon') }}" id="remove-coupon-form">
                    @csrf
                    <input class="form-control text-success fw-bold" type="text" name="coupon_code" placeholder="Coupon Code" value="{{ session()->get('coupon')['code'] }} Applied!" readonly>
                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4 text-danger" type="submit" value="REMOVE COUPON">
                </form>
            @endif
            @if(Session()->has('success'))
                <p class="text-success mt-2">{{ session()->get('success') }}</p>
            @elseif(Session()->has('error'))
                <p class="text-danger mt-2">{{ session()->get('error') }}</p>
            @endif
        </div>
    </div>
    <div class="shopping-cart__totals-wrapper mt-4">
        <div class="shopping-cart__totals">
            <h3>Cart Totals</h3>
            @include('partials.cart-totals', [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shippingCost' => $shippingCost,
                'finalTotal' => $finalTotal
            ])
        </div>
    </div>
@else
    <p class="text-center">Your cart is empty.</p>
    <a href="{{ route('shop.index') }}" class="btn btn-info">Shop Now</a>
@endif