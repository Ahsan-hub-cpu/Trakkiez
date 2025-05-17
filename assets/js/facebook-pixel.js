document.addEventListener('DOMContentLoaded', function () {
    const catalogIdMapping = {
        "7": "lzcxdcwcjq",
        "8": "vvdkpfyo97",
        "9": "r6hbm1fys5",
        "10": "78okh2lki8",
        "11": "kpcuffj8qf",
        "12": "n37sgyamlh",
        "13": "o71vv7yw03",
        "14": "i5hyrhxj5u",
        "15": "cxsgtz0uaa",
        "16": "9svfprctuj",
        "17": "8yior2enng",
        "18": "95gwctlrqb",
        "19": "ok8gk6giow",
        "20": "m265cq9rfy",
        "21": "h5nkmf7z7j",
        "22": "kqgnmnpetl",
        "23": "zuc6dz8spm",
        "24": "htratecte3",
        "25": "3249vkp896",
        "26": "s5sk2qd9t9",
        "27": "btvi71orfs",
        "28": "x641eyppw2",
        "29": "rdeiaok8if",
        "30": "moi7fdic3w",
        "31": "yti5zvhg08",
        "32": "yti5zvhg08",
        "33": "lkdawofeo8",
        "34": "2mo4k3xeit",
        "35": "khdxo55zun",
        "36": "uktf65qy1r",
        "37": "5908gpou8j"
    };

    document.addEventListener('click', function (e) {
        const link = e.target.closest('.product-link');
        if (link) {
            const productCard = link.closest('.product-card');
            if (productCard && productCard.querySelector('.sold-out-badge')) {
                return; // Don't track sold out products
            }

            const productId = link.getAttribute('data-product-id');
            const catalogId = catalogIdMapping[productId];
            const productName = link.getAttribute('data-product-name');
            const productPrice = parseFloat(link.getAttribute('data-product-price'));
            const productCategory = link.getAttribute('data-product-category');

            if (catalogId && productName && productPrice && productCategory && typeof fbq !== 'undefined') {
                fbq('track', 'ViewContent', {
                    content_ids: [catalogId],
                    content_name: productName,
                    content_type: 'product',
                    value: productPrice,
                    currency: 'PKR',
                    content_category: productCategory
                });
            } else {
                console.warn('ViewContent tracking failed:', {
                    productId, catalogId, productName, productPrice, productCategory
                });
            }
        }
    });
});
