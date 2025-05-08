@if (Cart::instance('cart')->content()->count() > 0)
    @php
        $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $shippingCost = ($subtotal > 6999) ? 0 : 250;
        $tax = (float) str_replace(',', '', Cart::instance('cart')->tax());
        $finalTotal = (float) str_replace(',', '', Cart::instance('cart')->total()) + $shippingCost;
    @endphp
    <div class="cart-table__wrapper">
        <table class="cart-table table table-borderless">
            <tbody>
                @foreach (Cart::instance('cart')->content() as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('uploads/products/thumbnails/' . $item->options->image) }}" alt="{{ $item->name }}" width="50">
                        </td>
                        <td>
                            <a href="{{ route('shop.product.details', ['product_slug' => $item->options->slug]) }}">{{ $item->name }}</a>
                        </td>
                        <td>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary cart-qty-reduce" data-row-id="{{ $item->rowId }}">-</button>
                                <input type="number" class="form-control cart-qty-input" value="{{ $item->qty }}" readonly>
                                <button class="btn btn-outline-secondary cart-qty-increase" data-row-id="{{ $item->rowId }}">+</button>
                            </div>
                            <div class="stock-error text-danger" id="stock-error-{{ $item->rowId }}"></div>
                        </td>
                        <td class="shopping-cart__subtotal">PKR {{ number_format($item->subtotal, 2) }}</td>
                        <td>
                            <button class="btn btn-danger cart-remove-item" data-row-id="{{ $item->rowId }}">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="cart-coupon">
            <input type="text" id="coupon-code" class="form-control" placeholder="Coupon Code">
            <button id="apply-coupon" class="btn btn-primary">Apply Coupon</button>
            @if (session('coupon'))
                <button id="remove-coupon" class="btn btn-secondary">Remove Coupon</button>
            @endif
        </div>
        @include('partials.cart-totals', [
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'tax' => $tax,
            'finalTotal' => $finalTotal
        ])
    </div>
@else
    <p class="text-center">Your cart is empty.</p>
    <a href="{{ route('shop.index') }}" class="btn btn-info">Shop Now</a>
@endif