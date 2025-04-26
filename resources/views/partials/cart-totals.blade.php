<table class="cart-totals">
    <tbody>
        @if(session()->has('discounts'))
            @php
                $discountData = session()->get('discounts');
                $discount = (float) $discountData['discount'];
                $discountedSubtotal = (float) $discountData['subtotal'];
                $discountTax = (float) $discountData['tax'];
                $discountTotal = (float) str_replace(',', '', $discountData['total']);
                $finalTotal = $discountTotal + $shippingCost;
            @endphp
            <tr>
                <th>Subtotal</th>
                <td>PKR {{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <th>Discount {{ session()->get('coupon')['code'] }}</th>
                <td>-PKR {{ number_format($discount, 2) }}</td>
            </tr>
            <tr>
                <th>Subtotal After Discount</th>
                <td>PKR {{ number_format($discountedSubtotal, 2) }}</td>
            </tr>
            <tr>
                <th>SHIPPING</th>
                <td class="text-right">
                    @if($shippingCost == 0)
                        Free
                    @else
                        PKR {{ number_format($shippingCost, 2) }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>VAT</th>
                <td>PKR {{ number_format($discountTax, 2) }}</td>
            </tr>
            <tr class="cart-total">
                <th>Total</th>
                <td>PKR {{ number_format($finalTotal, 2) }}</td>
            </tr>
        @else
            <tr>
                <th>Subtotal</th>
                <td>PKR {{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <th>SHIPPING</th>
                <td class="text-right">
                    @if($shippingCost == 0)
                        Free
                    @else
                        PKR {{ number_format($shippingCost, 2) }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>VAT</th>
                <td>PKR {{ number_format($tax, 2) }}</td>
            </tr>
            <tr class="cart-total">
                <th>Total</th>
                <td>PKR {{ number_format($finalTotal, 2) }}</td>
            </tr>
        @endif
    </tbody>
</table>