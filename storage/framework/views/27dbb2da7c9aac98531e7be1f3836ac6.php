<table class="cart-totals">
    <tbody>
        <tr>
            <th>Subtotal</th>
            <td>PKR <?php echo e(number_format($subtotal, 2)); ?></td>
        </tr>
        <?php if(session()->has('discounts')): ?>
            <tr>
                <th>Discount <?php echo e(session('coupon.code')); ?></th>
                <td>-PKR <?php echo e(number_format((float)session('discounts.discount'), 2)); ?></td>
            </tr>
            <tr>
                <th>Subtotal After Discount</th>
                <td>PKR <?php echo e(number_format((float)session('discounts.subtotal'), 2)); ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th>SHIPPING</th>
            <td class="text-right">PKR <?php echo e(number_format($shippingCost, 2)); ?></td>
        </tr>
        <tr>
            <th>VAT</th>
            <td>PKR <?php echo e(number_format($tax, 2)); ?></td>
        </tr>
        <tr class="cart-total">
            <th>Total</th>
            <td>PKR <?php echo e(number_format($finalTotal, 2)); ?></td>
        </tr>
    </tbody>
</table><?php /**PATH C:\xampp\htdocs\trakkiez\resources\views/partials/cart-totals.blade.php ENDPATH**/ ?>