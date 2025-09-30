<?php if(Cart::instance('cart')->content()->count() > 0): ?>
    <?php
        $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $shippingCost = ($subtotal > 5999) ? 0 : 250;
        $tax = (float) str_replace(',', '', Cart::instance('cart')->tax());
        $finalTotal = (float) str_replace(',', '', Cart::instance('cart')->total()) + $shippingCost;
    ?>
    <div class="cart-table__wrapper">
        <table class="cart-table table table-borderless">
            <tbody>
                <?php $__currentLoopData = Cart::instance('cart')->content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <img src="<?php echo e(asset('uploads/products/thumbnails/' . $item->options->image)); ?>" alt="<?php echo e($item->name); ?>" width="50">
                        </td>
                        <td>
                            <a href="<?php echo e(route('shop.product.details', ['product_slug' => $item->options->slug])); ?>"><?php echo e($item->name); ?></a>
                        </td>
                        <td>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary cart-qty-reduce" data-row-id="<?php echo e($item->rowId); ?>">-</button>
                                <input type="number" class="form-control cart-qty-input" value="<?php echo e($item->qty); ?>" readonly>
                                <button class="btn btn-outline-secondary cart-qty-increase" data-row-id="<?php echo e($item->rowId); ?>">+</button>
                            </div>
                            <div class="stock-error text-danger" id="stock-error-<?php echo e($item->rowId); ?>"></div>
                        </td>
                        <td class="shopping-cart__subtotal">PKR <?php echo e(number_format($item->subtotal, 2)); ?></td>
                        <td>
                            <button class="btn btn-danger cart-remove-item" data-row-id="<?php echo e($item->rowId); ?>">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="cart-coupon">
            <input type="text" id="coupon-code" class="form-control" placeholder="Coupon Code">
            <button id="apply-coupon" class="btn btn-primary">Apply Coupon</button>
            <?php if(session('coupon')): ?>
                <button id="remove-coupon" class="btn btn-secondary">Remove Coupon</button>
            <?php endif; ?>
        </div>
        <?php echo $__env->make('partials.cart-totals', [
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'tax' => $tax,
            'finalTotal' => $finalTotal
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php else: ?>
    <p class="text-center">Your cart is empty.</p>
    <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-info">Shop Now</a>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\trakkiez\resources\views/partials/cart-modal-content.blade.php ENDPATH**/ ?>