<?php $__env->startSection('content'); ?>
<style>
  /* Global Image Quality Improvements */
  img {
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
  }

  /* Shop Page Color Scheme */
  .shop-header {
      background: var(--bg-gradient-dark);
      color: white;
      padding: 60px 0;
      text-align: center;
      position: relative;
      overflow: hidden;
  }

  .shop-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="shopGrid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="%23ff6b6b" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23shopGrid)"/></svg>');
      opacity: 0.1;
      z-index: 1;
  }

  .shop-title {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 1rem;
      position: relative;
      z-index: 2;
  }

  .shop-subtitle {
      font-size: 1.2rem;
      opacity: 0.9;
      position: relative;
      z-index: 2;
  }

  .filter-section {
      background: white;
      padding: 30px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-light);
      margin-bottom: 30px;
  }

  .filter-title {
      color: var(--text-primary);
      font-weight: 700;
      margin-bottom: 20px;
      font-size: 1.3rem;
  }

  .filter-group {
      margin-bottom: 20px;
  }

  .filter-label {
      color: var(--text-secondary);
      font-weight: 600;
      margin-bottom: 10px;
      display: block;
  }

  .filter-select {
      border: 2px solid #e9ecef;
      border-radius: var(--border-radius-sm);
      padding: 10px 15px;
      width: 100%;
      transition: var(--transition);
  }

  .filter-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
      outline: none;
  }

  .price-range {
      margin-top: 10px;
  }

  .price-input {
      border: 2px solid #e9ecef;
      border-radius: var(--border-radius-sm);
      padding: 8px 12px;
      width: 100%;
      transition: var(--transition);
  }

  .price-input:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
      outline: none;
  }

  .apply-filters-btn {
      background: var(--bg-gradient);
      border: none;
      color: white;
      padding: 12px 30px;
      border-radius: var(--border-radius-sm);
      font-weight: 600;
      transition: var(--transition);
      width: 100%;
  }

  .apply-filters-btn:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-medium);
  }

  .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 30px;
      margin-top: 30px;
  }

  .product-card {
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-light);
      transition: var(--transition);
      overflow: hidden;
  }

  .product-card:hover {
      transform: translateY(-10px);
      box-shadow: var(--shadow-medium);
  }

  .product-image {
      width: 100%;
      height: 250px;
      object-fit: cover;
      transition: var(--transition);
  }

  .product-card:hover .product-image {
      transform: scale(1.05);
  }

  .product-info {
      padding: 20px;
  }

  .product-title {
      color: var(--text-primary);
      font-weight: 600;
      margin-bottom: 10px;
      font-size: 1.1rem;
  }

  .product-price {
      color: var(--primary-color);
      font-weight: 700;
      font-size: 1.2rem;
      margin-bottom: 15px;
  }

  .product-actions {
      display: flex;
      gap: 10px;
  }

  .add-to-cart-btn {
      background: var(--bg-gradient);
      border: none;
      color: white;
      padding: 10px 20px;
      border-radius: var(--border-radius-sm);
      font-weight: 600;
      transition: var(--transition);
      flex: 1;
  }

  .add-to-cart-btn:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-light);
  }

  .wishlist-btn {
      background: transparent;
      border: 2px solid var(--primary-color);
      color: var(--primary-color);
      padding: 10px;
      border-radius: var(--border-radius-sm);
      transition: var(--transition);
      width: 45px;
      height: 45px;
      display: flex;
      align-items: center;
      justify-content: center;
  }

  .wishlist-btn:hover {
      background: var(--primary-color);
      color: white;
      transform: scale(1.1);
  }

  .pagination {
      margin-top: 50px;
      display: flex;
      justify-content: center;
  }

  .pagination .page-link {
      color: var(--primary-color);
      border-color: var(--primary-color);
      padding: 10px 15px;
      margin: 0 5px;
      border-radius: var(--border-radius-sm);
      transition: var(--transition);
  }

  .pagination .page-link:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-2px);
  }

  .pagination .page-item.active .page-link {
      background: var(--bg-gradient);
      border-color: var(--primary-color);
      color: white;
  }

  .no-products {
      text-align: center;
      padding: 60px 20px;
      color: var(--text-secondary);
  }

  .no-products i {
      font-size: 4rem;
      color: var(--primary-color);
      margin-bottom: 20px;
  }

  .no-products h3 {
      color: var(--text-primary);
      margin-bottom: 10px;
  }

  .no-products p {
      font-size: 1.1rem;
  }

  /* Mobile Responsive */
  @media (max-width: 768px) {
      .shop-header {
          padding: 40px 0;
      }
      
      .shop-title {
          font-size: 2.5rem;
      }
      
      .shop-subtitle {
          font-size: 1rem;
      }
      
      .filter-section {
          padding: 20px;
          margin-bottom: 20px;
      }
      
      .product-grid {
          grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
          gap: 20px;
      }
      
      .product-info {
          padding: 15px;
      }
  }

  @media (max-width: 576px) {
      .product-grid {
          grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
          gap: 15px;
      }
      
      .product-actions {
          flex-direction: column;
      }
      
      .wishlist-btn {
          width: 100%;
          height: 40px;
      }
  }

  .filled-heart { color: orange; }
  .slideshow-bg { position: relative; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; }
  .slideshow-bg__img { width: 100%; height: 100%; object-fit: contain; }
 
  .product-card { 
    background: transparent; 
    border: none; 
    transition: transform 0.2s ease; 
    width: 90%; 
    margin: 0 auto; 
  }
  /* .product-card:hover { 
    transform: translateY(-3px); 
  } */

  .pc__img-wrapper { 
    overflow: hidden; 
    border-radius: 8px; 
    position: relative; 
  }

  .pc__img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover;  
    object-position: center;
    border-radius: 8px; 
    transition: transform 0.3s ease; 
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
  }

  /* .product-card:hover .pc__img { 
    transform: scale(1.05); 
  }
  .secondary-img { 
    position: absolute; 
    top: 0; 
    left: 0; 
    opacity: 0; 
    transition: opacity 0.3s ease; 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
    border-radius: 8px; 
    image-rendering: crisp-edges; 
  } */
/*  
  .pc__img-wrapper:hover .primary-img { 
    opacity: 0; 
  }
  .pc__img-wrapper:hover .secondary-img { 
    opacity: 1; 
  } */
  .pc__atc { font-size: 0.875rem; padding: 0.375rem 0.75rem; opacity: 0; transition: opacity 0.3s ease, background-color 0.3s ease; }
  /* .product-card:hover .pc__atc { opacity: 1; } */
  .pc__btn-wl { opacity: 0; transition: opacity 0.3s ease; }
  /* .product-card:hover .pc__btn-wl { opacity: 1; } */
  .pc__title { font-size: 1rem; font-weight: 500; color: #333; transition: color 0.3s ease; }
  /* .pc__title:hover { color: #ff6f61; } */
  .product-card__price { font-size: 0.9375rem; }
  .money.price { color: #333; }
  .money.price s { color: #999; }
  .products-grid .col { margin-bottom: 70px; }
  .container { padding-left: 30px; padding-right: 30px; }
  .filter-section { background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
  .filter-section .form-select { border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px; font-size: 14px; transition: all 0.3s ease; }
  .filter-section .form-select:hover { border-color: #ff6f61; }
  .filter-section .form-select:focus { border-color: #ff6f61; box-shadow: 0 0 0 2px rgba(255, 111, 97, 0.2); }

  .sold-out-badge {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: #ff9800;
    color: #fff;
    font-size: 0.9rem;
    font-weight: bold;
    padding: 4px 8px;
    border-radius: 5px;
    z-index: 10;
  }
  </style>

<div class="container mb-4">
  <div class="row">
    <div class="col-md-3 col-sm-6 mb-3">
      <select id="category-filter" class="form-select">
        <option value="">Filter by Category</option>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
      <select id="brand-filter" class="form-select">
        <option value="">Filter by Brand</option>
        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($brand->id); ?>" <?php echo e(request('brand') == $brand->id ? 'selected' : ''); ?>><?php echo e($brand->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
      <select id="color-filter" class="form-select">
        <option value="">Filter by Color</option>
        <?php $__currentLoopData = \App\Models\Colour::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($color->id); ?>" <?php echo e(request('color') == $color->id ? 'selected' : ''); ?>><?php echo e($color->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
      <button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#priceFilterModal">
          Filter by Price
      </button>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-3 col-sm-6 mb-3">
      <select id="sort-by" class="form-select">
        <option value="">Sort By</option>
        <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Newest to Oldest</option>
        <option value="oldest" <?php echo e(request('sort') == 'oldest' ? 'selected' : ''); ?>>Oldest to Newest</option>
        <option value="a-z" <?php echo e(request('sort') == 'a-z' ? 'selected' : ''); ?>>Alphabetically A to Z</option>
        <option value="z-a" <?php echo e(request('sort') == 'z-a' ? 'selected' : ''); ?>>Alphabetically Z to A</option>
        <option value="price-low-high" <?php echo e(request('sort') == 'price-low-high' ? 'selected' : ''); ?>>Price Low to High</option>
        <option value="price-high-low" <?php echo e(request('sort') == 'price-high-low' ? 'selected' : ''); ?>>Price High to Low</option>
      </select>
    </div>
  </div>
</div>

<?php if(request()->has('category') || request()->has('brand') || request()->has('color') || request()->has('price_from') || request()->has('price_to') || request()->has('sort')): ?>
  <div class="text-center mt-3">
    <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-outline-dark">Clear Filter</a>
  </div>
<?php endif; ?>

<div class="container mb-3">
  <div class="row">
    <div class="col">
      <p class="lead">
        <?php if($products instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
             <?php echo e($products->total()); ?> products
        <?php else: ?>
            <?php echo e(count($products)); ?> products
        <?php endif; ?>
      </p>
    </div>
  </div>
</div>

<div class="container">
  <div class="products-grid row row-cols-1 row-cols-md-3 g-4 mt-4">
  <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col">
        <div class="product-card card h-100 border-0 bg-transparent">
            <div class="pc__img-wrapper position-relative">
                <a href="<?php echo e(route('shop.product.details', ['product_slug' => $product->slug])); ?>">
                    <img loading="lazy" src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>" 
                        alt="<?php echo e($product->name); ?>" 
                        class="pc__img primary-img card-img-top rounded"
                        width="400" height="400">
                </a>
                <?php if($product->stock_status === 'out_of_stock'): ?>
                  <div class="sold-out-badge">Sold Out</div>
                <?php endif; ?>
            </div>
            <div class="card-body px-0 pb-0">
              <p class="pc__category text-muted small mb-1"><?php echo e($product->category ? $product->category->name : 'N/A'); ?></p>
              <h6 class="pc__title card-title mb-2">
                <a href="<?php echo e(route('shop.product.details', ['product_slug' => $product->slug])); ?>" class="text-dark text-decoration-none">
                  <?php echo e($product->name); ?>

                </a>
              </h6>
              <div class="product-card__price d-flex align-items-center mb-2">
                <span class="money price fw-bold">
                  <?php if($product->sale_price): ?>
                    <s class="text-muted me-2">PKR <?php echo e($product->regular_price); ?></s> PKR <?php echo e($product->sale_price); ?>

                  <?php else: ?>
                    PKR <?php echo e($product->regular_price); ?>

                  <?php endif; ?>
                </span>
              </div>
              <?php if(Cart::instance("wishlist")->content()->where('id', $product->id)->count() > 0): ?>
                <form method="POST" action="<?php echo e(route('wishlist.remove', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId])); ?>">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="pc__btn-wl btn btn-link p-0 position-absolute top-0 end-0 mt-2 me-2" title="Remove from Wishlist">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="orange" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_heart" />
                    </svg>
                  </button>
                </form>
              <?php else: ?>
                <form method="POST" action="<?php echo e(route('wishlist.add')); ?>">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="id" value="<?php echo e($product->id); ?>" />
                  <input type="hidden" name="name" value="<?php echo e($product->name); ?>" />
                  <input type="hidden" name="quantity" value="1" />
                  <input type="hidden" name="price" value="<?php echo e($product->sale_price == '' ? $product->regular_price : $product->sale_price); ?>" />
                  <button type="submit" class="pc__btn-wl btn btn-link p-0 position-absolute top-0 end-0 mt-2 me-2" title="Add To Wishlist">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_heart" />
                    </svg>
                  </button>
                </form>
              <?php endif; ?>
            </div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>

<?php if(!request()->has('color') && !request()->has('price_from') && !request()->has('price_to') && !request()->has('sort') && !request()->has('category') && !request()->has('brand')): ?>
  <div class="divider"></div>
  <div class="flex items-center justify-between flex-wrap gap10 wgp pagination">
    <?php echo e($products->withQueryString()->links('pagination::bootstrap-5')); ?>

  </div>
<?php endif; ?>

<div class="modal fade" id="priceFilterModal" tabindex="-1" aria-labelledby="priceFilterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="priceFilterModalLabel">Filter by Price</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="price-from-modal" class="form-label">Price From</label>
          <input type="number" class="form-control" id="price-from-modal" placeholder="Enter minimum price" value="<?php echo e(request('price_from')); ?>">
        </div>
        <div class="mb-3">
          <label for="price-to-modal" class="form-label">Price To</label>
          <input type="number" class="form-control" id="price-to-modal" placeholder="Enter maximum price" value="<?php echo e(request('price_to')); ?>">
        </div>
        <div class="mb-3">
          <small class="text-muted">Highest price is PKR <?php echo e($maxPrice); ?></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="apply-price-filter-modal">Apply</button>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(function(){
    const categoryLinks = document.querySelectorAll('.trakkiez-category-link[data-has-dropdown]');
    let activeDropdown = null;
    let activeLink = null;

    function closeAllDropdowns() {
        document.querySelectorAll('.trakkiez-subcategories').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
        document.querySelectorAll('.trakkiez-category-link').forEach(link => {
            link.classList.remove('active');
        });
        activeDropdown = null;
        activeLink = null;
    }

    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const categoryId = this.getAttribute('data-category');
            const dropdown = document.getElementById(`subcategories-${categoryId}`);
            
            if (activeDropdown === dropdown) {
                closeAllDropdowns();
            } else {
                closeAllDropdowns();
                dropdown.classList.add('active');
                this.classList.add('active');
                activeDropdown = dropdown;
                activeLink = this;

                // Center the category item
                const container = document.querySelector('.trakkiez-category-header');
                const item = this.closest('.trakkiez-category-item');
                const containerWidth = container.offsetWidth;
                const itemWidth = item.offsetWidth;
                const scrollLeft = item.offsetLeft - (containerWidth / 2) + (itemWidth / 2);
                
                container.scrollTo({
                    left: scrollLeft,
                    behavior: 'smooth'
                });
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.trakkiez-category-item')) {
            closeAllDropdowns();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
        }
    });

    // Filter and sort handlers
    $('#category-filter').on('change', function() {
        updateUrl('category', $(this).val());
    });

    $('#brand-filter').on('change', function() {
        updateUrl('brand', $(this).val());
    });

    $('#color-filter').on('change', function() {
        updateUrl('color', $(this).val());
    });

    $('#sort-by').on('change', function() {
        updateUrl('sort', $(this).val());
    });

    $('#apply-price-filter-modal').on('click', function() {
        var priceFrom = $('#price-from-modal').val();
        var priceTo = $('#price-to-modal').val();
        var url = new URL(window.location.href);
        var searchParams = new URLSearchParams(url.search);
        
        if (priceFrom) {
            searchParams.set('price_from', priceFrom);
        } else {
            searchParams.delete('price_from');
        }
        
        if (priceTo) {
            searchParams.set('price_to', priceTo);
        } else {
            searchParams.delete('price_to');
        }
        
        url.search = searchParams.toString();
        window.location.href = url.toString();
    });

    function updateUrl(key, value) {
        var url = new URL(window.location.href);
        var searchParams = new URLSearchParams(url.search);
        if (value) {
            searchParams.set(key, value);
        } else {
            searchParams.delete(key);
        }
        url.search = searchParams.toString();
        window.location.href = url.toString();
    }

    // Hover effect for product cards
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        const mainImg = card.querySelector('.primary-img');
        const hoverImg = card.querySelector('.secondary-img');
        if (hoverImg) {
            card.addEventListener('mouseover', () => {
                mainImg.style.opacity = '0';
                hoverImg.style.opacity = '1';
            });
            card.addEventListener('mouseout', () => {
                mainImg.style.opacity = '1';
                hoverImg.style.opacity = '0';
            });
            card.addEventListener('touchstart', () => {
                mainImg.style.opacity = '0';
                hoverImg.style.opacity = '1';
            });
            card.addEventListener('touchend', () => {
                mainImg.style.opacity = '1';
                hoverImg.style.opacity = '0';
            });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\trakkiez\resources\views/shop.blade.php ENDPATH**/ ?>