document.addEventListener('DOMContentLoaded', function () {
    // Use event delegation to handle clicks on product links
    document.addEventListener('click', function (e) {
        const link = e.target.closest('.product-link');
        if (link) {
            // Check if product is sold out
            const productCard = link.closest('.product-card');
            if (productCard && productCard.querySelector('.sold-out-badge')) {
                return; // Skip tracking for sold-out products
            }

            // Get product details from data attributes
            const productId = link.getAttribute('data-product-id');
            const productName = link.getAttribute('data-product-name');
            const productPrice = parseFloat(link.getAttribute('data-product-price'));
            const productCategory = link.getAttribute('data-product-category');

            // Track ViewContent event
            if (productId && productName && productPrice && productCategory) {
                fbq('track', 'ViewContent', {
                    content_ids: [productId],
                    content_name: productName,
                    content_type: 'product',
                    value: productPrice,
                    currency: 'PKR',
                    content_category: productCategory
                });
            }
        }
    });
});