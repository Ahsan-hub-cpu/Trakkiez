<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/animate.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/animation.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap-select.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('font/fonts.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('icon/style.css')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.icon')); ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo e(asset('images/favicon.icon')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/sweetalert.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/custom.css')); ?>">
    <?php echo $__env->yieldPushContent("styles"); ?>
</head>
<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="index.html" id="site-logo-inner">
                            <img id="logo_header_1" alt="" src="<?php echo e(asset('images/logo/logo.jpg')); ?>"
                                data-light="<?php echo e(asset('images/logo/logo.jpg')); ?>" data-dark="<?php echo e(asset('images/logo/logo.jpg')); ?>">
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="<?php echo e(route('admin.index')); ?>">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="center-item">
                            <ul class="menu-list">
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Products</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="<?php echo e(route('admin.product.add')); ?>">
                                                <div class="text">Add Product</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="<?php echo e(route('admin.products')); ?>">
                                                <div class="text">Products</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Brand</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="<?php echo e(route('admin.brand.add')); ?>">
                                                <div class="text">New Brand</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="<?php echo e(route('admin.brands')); ?>">
                                                <div class="text">Brands</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Category</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="<?php echo e(route('admin.category.add')); ?>">
                                                <div class="text">New Category</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="<?php echo e(route('admin.categories')); ?>">
                                                <div class="text">Categories</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="<?php echo e(route('admin.orders')); ?>" class="menu-item-button">
                                        <div class="icon"><i class="icon-file-plus"></i></div>
                                        <div class="text">Order</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="<?php echo e(route('admin.orders')); ?>">
                                                <div class="text">Orders</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item">
                                    <a href="<?php echo e(route('admin.slides')); ?>">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Slides</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="<?php echo e(route('admin.coupons')); ?>">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Coupons</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="<?php echo e(route('admin.contacts')); ?>">
                                        <div class="icon"><i class="icon-mail"></i></div>
                                        <div class="text">Messages</div>
                                    </a>
                                </li>
                                 <li class="menu-item">
                                    <a href="<?php echo e(route('admin.reviews')); ?>">
                                        <div class="icon"><i class="icon-mail"></i></div>
                                        <div class="text">Reviews</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form">
                                        <?php echo csrf_field(); ?>
                                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <div class="icon"><i class="icon-log-out"></i></div>
                                            <div class="text">LogOut</div>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="section-content-right">
                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                <a href="<?php echo e(route('admin.index')); ?>">
                                    <img id="logo_header_mobile" alt="" src="<?php echo e(asset('images/logo/logo.jpg')); ?>"
                                        data-light="<?php echo e(asset('images/logo/logo.jpg')); ?>" data-dark="<?php echo e(asset('images/logo/logo.jpg')); ?>"
                                        data-width="154px" data-height="52px" data-retina="<?php echo e(asset('images/logo/logo.jpg')); ?>">
                                </a>
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>

                                <form class="form-search flex-grow">
                                    <fieldset class="name">
                                        <input type="text" placeholder="Search here..." class="show-search" name="name"
                                            id="search-input" tabindex="2" value="" aria-required="true" required="" autocomplete="off">
                                    </fieldset>
                                    <div class="button-submit">
                                        <button type="submit"><i class="icon-search"></i></button>
                                    </div>
                                    <div class="box-content-search">
                                        <ul id="box-content-search"></ul>
                                    </div>
                                </form>
                            </div>

                            <div class="header-grid">
                                <div class="popup-wrap message type-header">
                                    <div class="dropdown">
                                    </div>
                                </div>

                                <div class="popup-wrap user type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-user wg-user">
                                                <span class="image">
                                                    <img src="<?php echo e(asset('images/Ahsan Hanif-Photoroom.jpg')); ?>" alt="Admin Profile Picture">
                                                </span>
                                                <span class="flex flex-column">
                                                    <span class="body-title mb-2">Ahsan Hanif</span>
                                                    <span class="text-tiny"><?php echo e(Auth()->user()->utype == 'ADM' ? 'Admin' : 'User'); ?></span>
                                                </span>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="main-content">
                        <?php echo $__env->yieldContent("content"); ?>
                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2024 Trakkiez Store</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap-select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/apexcharts/apexcharts.js')); ?>"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $("#search-input").on("keyup", function() {
                var searchQuery = $(this).val();

                if (searchQuery.length > 2) {
                    $.ajax({
                        type: "GET",
                        url: "<?php echo e(route('admin.search')); ?>",
                        data: { query: searchQuery },
                        dataType: "json",
                        success: function(data) {
                            $("#box-content-search").html("");
                            $.each(data, function(index, item) {
                                var url = "<?php echo e(route('admin.product.edit', ':id')); ?>";
                                url = url.replace(':id', item.id);
                                var imageUrl = "<?php echo e(asset('uploads/products/thumbnails')); ?>/" + item.image;
                                $("#box-content-search").append(`
                                    <li>
                                        <ul>
                                            <li class="product-item gap14 mb-10">
                                                <div class="image no-bg">
                                                    <img src="${imageUrl}" alt="${item.name}">
                                                </div>
                                                <div class="flex items-center justify-between gap20 flex-grow">
                                                    <div class="name">
                                                        <a href="${url}" class="body-text">${item.name}</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-10">
                                                <div class="divider"></div>
                                            </li>
                                        </ul>
                                    </li>
                                `);
                            });
                        }
                    });
                }
            });
        });
    </script>
    <?php echo $__env->yieldPushContent("scripts"); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\trakkiez\resources\views/layouts/admin.blade.php ENDPATH**/ ?>