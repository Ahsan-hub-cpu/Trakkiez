<table class="cart-totals">
    <tbody>
        <tr>
            <th>Subtotal</th>
            <td>PKR {{ number_format($subtotal, 2) }}</td>
        </tr>
        @if(session()->has('discounts'))
            <tr>
                <th>Discount {{ session('coupon.code') }}</th>
                <td>-PKR {{ number_format((float)session('discounts.discount'), 2) }}</td>
            </tr>
            <tr>
                <th>Subtotal After Discount</th>
                <td>PKR {{ number_format((float)session('discounts.subtotal'), 2) }}</td>
            </tr>
        @endif
        <tr>
            <th>SHIPPING</th>
            <td class="text-right">PKR {{ number_format($shippingCost, 2) }}</td>
        </tr>
        <tr>
            <th>VAT</th>
            <td>PKR {{ number_format($tax, 2) }}</td>
        </tr>
        <tr class="cart-total">
            <th>Total</th>
            <td>PKR {{ number_format($finalTotal, 2) }}</td>
        </tr>
    </tbody>
</table>