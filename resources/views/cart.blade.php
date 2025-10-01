@extends('layouts.app')
@section('content')
<style>
    /* Cart Page Color Scheme */
    .cart-header {
        background: #000000;
        color: white;
        padding: 60px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cart-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="cartGrid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="%23ffffff" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23cartGrid)"/></svg>');
        opacity: 0.1;
        z-index: 1;
    }

    .cart-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
        text-transform: uppercase;
    }

    .cart-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }

    .cart-item {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: 20px;
        margin-bottom: 20px;
        transition: var(--transition);
    }

    .cart-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .cart-item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: var(--border-radius-sm);
    }

    .cart-item-details h5 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 10px;
    }

    .cart-item-price {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.2rem;
    }

    .cart-item-total {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .qty-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .qty-control__decrease,
    .qty-control__increase {
        background: #000000;
        border: none;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .qty-control__decrease:hover,
    .qty-control__increase:hover {
        background: #333333;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .qty-control__decrease:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #e9ecef;
        color: #6c757d;
    }

    .qty-control__input {
        width: 60px;
        text-align: center;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-sm);
        padding: 8px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .qty-control__input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
        outline: none;
    }

    .remove-item-btn {
        background: #dc3545;
        border: none;
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(220, 53, 69, 0.2);
    }

    .remove-item-btn:hover {
        background: #c82333;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }

    .cart-totals {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: 30px;
        margin-top: 30px;
    }

    .cart-totals h4 {
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1.3rem;
    }

    .cart-totals td {
        text-align: right;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .cart-totals th {
        color: var(--text-secondary);
        font-weight: 600;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .cart-total th, .cart-total td {
        color: #000000;
        font-weight: bold;
        font-size: 1.3rem !important;
        border-top: 2px solid #000000;
        padding-top: 15px;
    }

    .checkout-btn {
        background: #000000;
        border: none;
        color: white;
        padding: 15px 30px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .checkout-btn:hover {
        background: #333333;
        transform: translateY(-1px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .continue-shopping-btn {
        background: transparent;
        border: 2px solid #000000;
        color: #000000;
        padding: 12px 25px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .continue-shopping-btn:hover {
        background: #000000;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .empty-cart {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-secondary);
    }

    .empty-cart i {
        font-size: 4rem;
        color: #000000;
        margin-bottom: 20px;
    }

    .empty-cart h3 {
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .empty-cart p {
        font-size: 1.1rem;
        margin-bottom: 30px;
    }

    .text-success {
        color: var(--success-color) !important;
    }

    .text-danger {
        color: var(--danger-color) !important;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .cart-header {
            padding: 40px 0;
        }
        
        .cart-title {
            font-size: 2.5rem;
        }
        
        .cart-item {
            padding: 15px;
        }
        
        .cart-item-image {
            width: 80px;
            height: 80px;
        }
        
        .cart-totals {
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .cart-title {
            font-size: 2rem;
        }
        
        .cart-item {
            text-align: center;
        }
        
        .qty-control {
            justify-content: center;
            margin: 15px 0;
        }
        
        .cart-totals {
            padding: 15px;
        }
    }
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Cart</h2>
        <div class="checkout-steps">
            <a href="javascript:void(0);" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0);" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0);" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Order Confirmation</em>
                </span>
            </a>
        </div>
        <div class="shopping-cart">
            @if($cartItems->count() > 0)
                <div class="cart-table__wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th></th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            // Set the fixed shipping cost conditionally based on cart subtotal.
                            $cartSubtotal = (float) str_replace(',', '', \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal());
                            $shippingCost = ($cartSubtotal > 6999) ? 0 : 250;
                        @endphp
                            @foreach ($cartItems as $cartItem)
                                <tr>
                                    <td>
                                        <div class="shopping-cart__product-item">
                                            <img loading="lazy" src="{{ asset('uploads/products/thumbnails/' . $cartItem->model->image) }}" width="120" height="120" alt="" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="shopping-cart__product-item__detail">
                                            <h4>{{ $cartItem->name }}</h4>
                                            <ul class="shopping-cart__product-item__options">
                                                <li>
                                                    Color: {{ $cartItem->options['colour'] ?? 'Default' }}
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="shopping-cart__product-price">PKR {{ $cartItem->price }}</span>
                                    </td>
                                    <td>
                                        <div class="qty-control position-relative">
                                            <input type="number" name="quantity" 
                                                   value="{{ \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->get($cartItem->rowId)->qty }}" 
                                                   min="1" 
                                                   readonly
                                                   class="qty-control__number text-center" 
                                                   data-rowid="{{ $cartItem->rowId }}"
                                                   data-max="{{ $cartItem->options->available_quantity }}"
                                                   data-global="{{ $cartItem->options->global_quantity }}">
                                            <button class="qty-control__reduce" data-action="reduce" data-rowid="{{ $cartItem->rowId }}">-</button>
                                            <button class="qty-control__increase" data-action="increase" data-rowid="{{ $cartItem->rowId }}">+</button>
                                        </div>
                                        <span class="text-danger stock-error" id="stock-error-{{ $cartItem->rowId }}"></span>
                                    </td>
                                    <td>
                                        <span class="shopping-cart__subtotal" id="subtotal-{{ $cartItem->rowId }}">PKR {{ \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->get($cartItem->rowId)->subtotal() }}</span>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.remove', ['rowId' => $cartItem->rowId]) }}">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="remove-cart">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                    <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="cart-table-footer">
                        @if(!Session()->has("coupon"))
                            <form class="position-relative bg-body" method="POST" action="{{ route('cart.applyCoupon') }}">
                                @csrf
                                <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                                <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit" value="APPLY COUPON">
                            </form>
                        @else
                            <form class="position-relative bg-body" method="POST" action="{{ route('cart.removeCoupon') }}">
                                @csrf
                                <input class="form-control text-success fw-bold" type="text" name="coupon_code" placeholder="Coupon Code" value="{{ session()->get('coupon')['code'] }} Applied!" readonly>
                                <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4 text-danger" type="submit" value="REMOVE COUPON">
                            </form>
                        @endif
                        <form class="position-relative bg-body" method="POST" action="{{ route('cart.empty') }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-light" type="submit">CLEAR CART</button>
                        </form>
                    </div>
                    <div>
                        @if(Session()->has('success'))
                            <p class="text-success">{{ session()->get('success') }}</p>
                        @elseif(Session()->has('error'))
                            <p class="text-danger">{{ session()->get('error') }}</p>
                        @endif
                    </div>
                </div>
                <div class="shopping-cart__totals-wrapper">
                    <div class="sticky-content">
                        <div class="shopping-cart__totals">
                            <h3>Cart Totals</h3>
                            @php
                                // Recalculate cart subtotal and shipping cost for totals
                                $cartSubtotal = (float) str_replace(',', '', \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal());
                                $shippingCost = ($cartSubtotal > 6999) ? 0 : 250;
                            @endphp
                            @if(Session()->has('discounts'))
                                <table class="cart-totals">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>PKR {{ \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Discount {{ Session::get("coupon")["code"] }}</th>
                                            <td>-PKR {{ Session::get("discounts")["discount"] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Subtotal After Discount</th>
                                            <td>PKR {{ Session::get("discounts")["subtotal"] }}</td>
                                        </tr>
                                        <tr>
                                            <th>SHIPPING</th>
                                            <td class="text-right">PKR {{ number_format($shippingCost, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>VAT</th>
                                            <td>PKR {{ Session::get("discounts")["tax"] }}</td>
                                        </tr>
                                        <tr class="cart-total">
                                            @php
                                                $discountTotal = (float) str_replace(',', '', Session::get("discounts")["total"]);
                                                $finalTotal = $discountTotal + $shippingCost;
                                            @endphp
                                            <th>Total</th>
                                            <td>PKR {{ number_format($finalTotal, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <table class="cart-totals">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>PKR {{ \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal() }}</td>
                                        </tr>
                                        <tr>
                                            <th>SHIPPING</th>
                                            <td class="text-right">PKR {{ number_format($shippingCost, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>VAT</th>
                                            <td>PKR {{ \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->tax() }}</td>
                                        </tr>
                                        <tr class="cart-total">
                                            @php
                                                $cartTotal = (float) str_replace(',', '', \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->total());
                                                $finalTotal = $cartTotal + $shippingCost;
                                            @endphp
                                            <th>Total</th>
                                            <td>PKR {{ number_format($finalTotal, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="mobile_fixed-btn_wrapper">
                            <div class="button-wrapper container">
                                <button type="button" class="btn btn-primary btn-checkout checkout-btn">PROCEED TO CHECKOUT</button>
                                <div id="checkout-error" class="text-danger"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 text-center pt-5 pb-5">
                        <p>No item found in your cart</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
$(document).ready(function(){

    // Initialize quantity inputs
    $('input.qty-control__number').each(function(){
        var $input = $(this);
        var availableQuantity = parseInt($input.data('max'));
        var globalQuantity = parseInt($input.data('global'));
        var allowedMax = Math.min(availableQuantity, globalQuantity);
        $input.attr('max', allowedMax);
        var currentVal = parseInt($input.val());
        if(currentVal > allowedMax) {
            currentVal = allowedMax;
            $input.val(allowedMax);
        }
        $input.data('lastValid', currentVal);
        var rowId = $input.data('rowid');
        updateButtonState(rowId);
    });

    // Update increase button state based on current quantity.
    function updateButtonState(rowId) {
        var $input = $('input.qty-control__number[data-rowid="'+ rowId +'"]');
        var maxVal = parseInt($input.attr('max'));
        var currentVal = parseInt($input.val());
        var $increaseButton = $('.qty-control__increase[data-rowid="'+ rowId +'"]');
        var $error = $('#stock-error-' + rowId);
        if(currentVal >= maxVal){
            $increaseButton.prop('disabled', true);
            $error.text("Only " + maxVal + " items are available.");
        } else {
            $increaseButton.prop('disabled', false);
            $error.text('');
        }
    }

    // When the increase button is clicked.
    $('.qty-control__increase').on('click', function(){
        var rowId = $(this).data('rowid');
        var $input = $('input.qty-control__number[data-rowid="'+ rowId +'"]');
        var lastValid = parseInt($input.data('lastValid'));
        var maxVal = parseInt($input.attr('max'));
        var $error = $('#stock-error-' + rowId);
        if(lastValid < maxVal) {
            $error.text('');
            increaseQuantity(rowId);
        } else {
            $error.text("Only " + maxVal + " items are available.");
        }
        updateButtonState(rowId);
    });

    // When the reduce button is clicked.
    $('.qty-control__reduce').on('click', function(){
        var rowId = $(this).data('rowid');
        var $input = $('input.qty-control__number[data-rowid="'+ rowId +'"]');
        var lastValid = parseInt($input.data('lastValid'));
        var $error = $('#stock-error-' + rowId);
        if(lastValid > 1) {
            $error.text('');
            reduceQuantity(rowId);
        }
        updateButtonState(rowId);
    });

    // Checkout redirection.
    $('.shopping-cart .btn-checkout').off('click').on('click', function() {
        window.location.href = "{{ route('cart.checkout') }}";
    });

    // AJAX function to increase quantity.
    function increaseQuantity(rowId) {
        $.ajax({
            url: "{{ route('cart.qty.increase', ['rowId' => ':rowId']) }}".replace(':rowId', rowId),
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success) {
                    var $input = $('input.qty-control__number[data-rowid="'+ rowId +'"]');
                    $input.val(response.newQuantity);
                    $input.data('lastValid', response.newQuantity);
                    $('#subtotal-' + rowId).text('PKR ' + response.subtotal);
                    // Replace the totals HTML with the response from the server.
                    $('.cart-totals').html(response.totals);
                    $('#stock-error-' + rowId).text('');
                    var maxVal = parseInt($input.attr('max'));
                    if(response.newQuantity >= maxVal) {
                        $('#stock-error-' + rowId).text("Only " + maxVal + " items are available.");
                    }
                    updateButtonState(rowId);
                } else {
                    $('#stock-error-' + rowId).text(response.message);
                }
            },
            error: function(xhr) {
                $('#checkout-error').text('An error occurred. Please try again.');
            }
        });
    }

    // AJAX function to reduce quantity.
    function reduceQuantity(rowId) {
        $.ajax({
            url: "{{ route('cart.qty.reduce', ['rowId' => ':rowId']) }}".replace(':rowId', rowId),
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success) {
                    var $input = $('input.qty-control__number[data-rowid="'+ rowId +'"]');
                    $input.val(response.newQuantity);
                    $input.data('lastValid', response.newQuantity);
                    $('#subtotal-' + rowId).text('PKR ' + response.subtotal);
                    // Replace the totals HTML with the response from the server.
                    $('.cart-totals').html(response.totals);
                    $('#stock-error-' + rowId).text('');
                    updateButtonState(rowId);
                } else {
                    $('#stock-error-' + rowId).text(response.message);
                }
            },
            error: function(xhr) {
                $('#checkout-error').text('An error occurred. Please try again.');
            }
        });
    }
});
</script>
@endpush -->