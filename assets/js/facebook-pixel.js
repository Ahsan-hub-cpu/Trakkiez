document.addEventListener('DOMContentLoaded', function () {
    // Catalog product IDs
    const catalog_content_ids = [
        '3u8uo21xiu', '907d1j48ca', 'iov4y9yskk', 'yr6p3ff89v', 'to0hdqaajw', 'o5b92itjj8', 'kd0ezgobi4', '72apcf9ubz', 'quswejalwx', '40nmsrb1cr', 'vmz2jx7hx3', '7ao9urd1q2',
        'b4rjfyp60j', '5nisf03qgp', '2z71q9pnk3', 'mzs5mver13', 'n58ff4phyo', 'pteix2o8l4', '0998cbv8um', 'c7q35ex74g', 'jc0zqvr255', '62nmi11ihc', 'aaudleo6yo',
        '1o04my2ey2', 'kdv7dnd481', 'emhbophar8', 'ohdp2r3eup', 'be4ta8zg54', '7mepqbl4bu', 'gpn1uz623j', 'cq8sxjx5bc'
    ];

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
            if (productId && productName && productPrice && productCategory && typeof fbq !== 'undefined') {
                fbq('track', 'ViewContent', {
                    content_ids: catalog_content_ids,
                    content_name: productName,
                    content_type: 'product',
                    value: productPrice,
                    currency: 'PKR',
                    content_category: productCategory,
                    catalog_content_ids: catalog_content_ids
                });
            } else {
                console.warn('ViewContent tracking failed: Missing data or Meta Pixel not initialized', {
                    productId, productName, productPrice, productCategory, fbqDefined: typeof fbq !== 'undefined'
                });
            }
        }
    });
});