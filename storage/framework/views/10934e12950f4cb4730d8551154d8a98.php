<?php $__env->startSection("content"); ?>
<main>
  <!-- Hero Section -->
  <section class="hero-section">
      <div class="hero-slider">
              <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="hero-slide <?php echo e($index === 0 ? 'active' : ''); ?>">
                  <div class="hero-background" style="background-image: url('<?php echo e(asset('uploads/slides/' . $slide->image)); ?>')"></div>
                  <div class="hero-overlay"></div>
                  <div class="hero-content">
                      <div class="container">
                          <div class="row align-items-center min-vh-100">
                              <div class="col-lg-6">
                                  <div class="hero-text">
                                      <h1 class="hero-title">Premium Mobile Cases</h1>
                                      <h2 class="hero-subtitle">Protect Your Device in Style</h2>
                                      <p class="hero-description">Discover our collection of high-quality, stylish mobile cases designed to provide maximum protection while maintaining the sleek look of your device.</p>
                                      <div class="hero-buttons">
                                          <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-primary btn-lg">Shop Now</a>
                                          <a href="#featured-products" class="btn btn-outline-light btn-lg">View Collection</a>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="hero-image">
                                      <img src="<?php echo e(asset('uploads/slides/' . $slide->image)); ?>" alt="Premium Mobile Cases" class="img-fluid">
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <!-- Slider Navigation -->
      <div class="slider-navigation">
              <div class="slider-dots">
                  <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <button class="slider-dot <?php echo e($index === 0 ? 'active' : ''); ?>" data-slide="<?php echo e($index); ?>"></button>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
          </div>
  </section>

  <!-- Featured Products Section -->
  <section id="featured-products" class="featured-products-section py-5">
      <div class="container">
          <div class="text-center mb-5">
              <h2 class="section-title">Featured Mobile Cases</h2>
              <p class="section-subtitle">Discover our most popular and trending mobile case designs</p>
              <a href="<?php echo e(route('shop.index', ['filter' => 'new-arrivals'])); ?>" class="btn btn-outline-primary">View All Products</a>
      </div>
      <div class="row justify-content-center">
          <div class="col-12">
          <div class="position-relative">
    <div class="swiper-container js-swiper-slider" data-settings='{
        "autoplay": false,
        "slidesPerView": 3,
        "slidesPerGroup": 1,
        "effect": "none",
        "loop": false,
        "preloadImages": false,
        "lazy": {
            "loadPrevNext": true,
            "loadPrevNextAmount": 1,
            "loadOnTransitionStart": true,
            "elementClass": "swiper-lazy",
            "loadingClass": "swiper-lazy-loading",
            "loadedClass": "swiper-lazy-loaded",
            "preloaderClass": "swiper-lazy-preloader"
        },
        "breakpoints": {
            "320": { "slidesPerView": 1, "slidesPerGroup": 1, "spaceBetween": 0 },
            "576": { "slidesPerView": 2, "slidesPerGroup": 1, "spaceBetween": 10 },
            "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 30 }
        },
        "watchSlidesVisibility": true,
        "watchSlidesProgress": true,
        "slidesOffsetBefore": 0,
        "slidesOffsetAfter": 0,
        "centerInsufficientSlides": true,
        "centeredSlides": false
    }'>
        <div class="swiper-wrapper">
            <?php $__currentLoopData = $newArrivals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide product-card">
                    <div class="product-card-inner">
                    <div class="pc__img-wrapper">
                        <a href="<?php echo e(route('shop.product.details', ['product_slug' => $product->slug])); ?>">
                            <img class="swiper-lazy pc__img" 
                                     data-srcset="<?php echo e(asset('uploads/products/' . $product->main_image)); ?> 600w, <?php echo e(asset('uploads/products/thumbnails/' . $product->main_image)); ?> 300w"
                                     data-sizes="(max-width: 576px) 300px, 600px"
                                 data-src="<?php echo e(asset('uploads/products/thumbnails/' . $product->main_image)); ?>" 
                                     alt="<?php echo e($product->name); ?> mobile case"
                                     width="600" height="600"
                                     loading="lazy">
                            <div class="swiper-lazy-preloader"></div>
                        </a>
                        <?php if($product->sale_price && $product->regular_price): ?>
                            <?php
                                $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                            ?>
                            <div class="discount-badge">SAVE <?php echo e($discount); ?>%</div>
                        <?php endif; ?>
                        <?php if($product->stock_status === 'out_of_stock'): ?>
                            <div class="sold-out-badge">Sold Out</div>
                        <?php endif; ?>
                            <div class="product-overlay">
                                <a href="<?php echo e(route('shop.product.details', ['product_slug' => $product->slug])); ?>" class="btn btn-primary btn-sm">View Details</a>
                            </div>
                    </div>
                    <div class="pc__info">
                            <div class="product-category"><?php echo e($product->category->name ?? 'Mobile Case'); ?></div>
                        <h6 class="pc__title">
                            <a href="<?php echo e(route('shop.product.details', ['product_slug' => $product->slug])); ?>">
                                <?php echo e($product->name); ?>

                            </a>
                        </h6>
                            <div class="product-features">
                                <span class="feature-tag">Shockproof</span>
                                <span class="feature-tag">Scratch Resistant</span>
                            </div>
                        <div class="product-card__price">
                            <?php if($product->sale_price): ?>
                                    <span class="price-old">PKR <?php echo e($product->regular_price); ?></span>
                                    <span class="price-new">PKR <?php echo e($product->sale_price); ?></span>
                            <?php else: ?>
                                    <span class="price-current">PKR <?php echo e($product->regular_price); ?></span>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
          </div>
      </div>
  </section>


  <style>
  /* Simple Category Cards */
  .category-card {
      height: 250px;
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--shadow-light);
      transition: var(--transition);
      text-decoration: none;
      color: inherit;
      position: relative;
      background: #fff;
      border: 2px solid transparent;
  }

  .category-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-medium);
      text-decoration: none;
      color: inherit;
      border-color: var(--primary-color);
  }

  .category-image {
      height: 180px;
      width: 100%;
      overflow: hidden;
      position: relative;
      background: var(--bg-light);
  }

  .category-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      transition: var(--transition);
  }

  .category-card:hover .category-image img {
      transform: scale(1.05);
  }

  .category-placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--bg-gradient);
      color: white;
      font-size: 2.5rem;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .category-info {
      padding: 20px;
      background: white;
      height: 70px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
  }

  .category-info h5 {
      font-size: 1.1rem;
      font-weight: 600;
      margin: 0 0 8px 0;
      color: var(--text-primary);
      line-height: 1.3;
  }

  .product-count {
      font-size: 0.9rem;
      color: var(--text-secondary);
      font-weight: 500;
  }

  /* Simple Brand Section */
  .choose-model-section {
      background: var(--bg-light);
      position: relative;
      overflow: hidden;
      min-height: 50vh;
      display: flex;
      align-items: center;
  }

  .choose-model-title {
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 1rem;
      position: relative;
      text-align: center;
  }

  .choose-model-title::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 3px;
      background: var(--bg-gradient);
      border-radius: 2px;
  }

  .choose-model-subtitle {
      font-size: 1rem;
      color: var(--text-secondary);
      margin-bottom: 2.5rem;
      text-align: center;
      font-weight: 400;
  }

  .brands-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      position: relative;
      z-index: 2;
      max-width: 1200px;
      margin: 0 auto;
      justify-items: center;
  }

  .brand-card {
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-light);
      transition: var(--transition);
      overflow: hidden;
      width: 250px;
      height: 180px;
      position: relative;
  }

  .brand-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-medium);
  }

  .brand-card-link {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      text-decoration: none;
      color: inherit;
      padding: 30px 20px;
      position: relative;
  }

  .brand-icon {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: var(--bg-gradient);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 15px;
      box-shadow: var(--shadow-light);
      transition: var(--transition);
  }

  .brand-card:hover .brand-icon {
      transform: scale(1.05);
      box-shadow: var(--shadow-medium);
  }

  .brand-icon-image {
      width: 40px;
      height: 40px;
      object-fit: contain;
      filter: brightness(0) invert(1);
  }

  .brand-icon-letter {
      font-size: 2rem;
      font-weight: 700;
      color: white;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .brand-label {
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--text-primary);
      text-align: center;
      margin: 0;
      transition: var(--transition);
  }

  .brand-card:hover .brand-label {
      color: var(--primary-color);
  }

  /* Responsive Design */
  @media (max-width: 1200px) {
      .brands-container {
          grid-template-columns: repeat(3, 1fr);
          gap: 25px;
      }
  }

  @media (max-width: 768px) {
      .choose-model-title {
          font-size: 2rem;
      }
      
      .choose-model-subtitle {
          font-size: 1rem;
          margin-bottom: 2rem;
      }
      
      .brands-container {
          grid-template-columns: repeat(3, 1fr);
          gap: 20px;
          max-width: 100%;
          padding: 0 15px;
      }
      
      .brand-card {
      width: 100%;
          max-width: 200px;
          height: 160px;
      }
      
      .brand-card-link {
          padding: 25px 15px;
      }
      
      .brand-icon {
          width: 60px;
          height: 60px;
          margin-bottom: 12px;
      }
      
      .brand-icon-letter {
          font-size: 1.8rem;
      }
      
      .brand-label {
      font-size: 1rem;
      }
  }

  @media (max-width: 576px) {
      .choose-model-section {
          min-height: 50vh;
          padding: 40px 0;
      }
      
      .choose-model-title {
          font-size: 1.8rem;
      }
      
      .choose-model-subtitle {
          font-size: 0.95rem;
          margin-bottom: 1.5rem;
      }
      
      .brands-container {
          grid-template-columns: repeat(3, 1fr);
          gap: 15px;
          padding: 0 10px;
      }
      
      .brand-card {
          width: 100%;
          max-width: 180px;
          height: 140px;
      }
      
      .brand-card-link {
          padding: 20px 10px;
      }
      
      .brand-icon {
          width: 50px;
          height: 50px;
          margin-bottom: 10px;
      }
      
      .brand-icon-letter {
          font-size: 1.5rem;
      }
      
      .brand-label {
          font-size: 0.9rem;
      }
  }

  @media (max-width: 480px) {
      .brands-container {
          grid-template-columns: repeat(3, 1fr);
          gap: 12px;
          padding: 0 5px;
      }
      
      .brand-card {
          width: 100%;
          max-width: 160px;
          height: 130px;
      }
      
      .brand-card-link {
          padding: 15px 8px;
      }
      
      .brand-icon {
          width: 45px;
          height: 45px;
          margin-bottom: 8px;
      }
      
      .brand-icon-letter {
          font-size: 1.3rem;
      }
      
      .brand-label {
          font-size: 0.8rem;
      }
  }

  /* Section Styling - Updated to use CSS variables */
  .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 1rem;
      position: relative;
      text-align: center;
  }

  .section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: var(--bg-gradient);
      border-radius: 2px;
  }

  .section-subtitle {
      font-size: 1.1rem;
      color: var(--text-secondary);
      margin-bottom: 2rem;
      text-align: center;
      font-weight: 400;
  }

  /* Beautiful Mobile Responsive Design - Fixed */
  @media (max-width: 768px) {
      /* Section Headers */
      .section-title {
          font-size: 2rem;
          margin-bottom: 1.5rem;
      }
      
      .section-subtitle {
          font-size: 1rem;
          margin-bottom: 2rem;
      }
      
      /* Category Cards - Tablet - Fixed Layout */
      .category-card {
          height: 200px;
          border-radius: 12px;
          margin-bottom: 1rem;
      }
      
      .category-image {
          height: 130px;
      }
      
      .category-info {
          padding: 15px;
          height: 70px;
      }
      
      .category-info h5 {
          font-size: 1rem;
          margin-bottom: 5px;
      }
      
      .product-count {
          font-size: 0.85rem;
      }
      
      /* Brand Cards - Tablet - Fixed Layout */
      .featured-brand-card {
          height: 180px;
          border-radius: 12px;
          margin-bottom: 1rem;
      }
      
      .featured-brand-placeholder {
          font-size: 1.5rem;
      }
      
      .featured-brand-card-title {
          font-size: 1rem;
      }
      
      .featured-brand-card-subtitle {
          font-size: 0.85rem;
      }
      
      /* Grid Adjustments */
      .row.g-3 {
          --bs-gutter-x: 1rem;
          --bs-gutter-y: 1rem;
      }
  }

  @media (max-width: 576px) {
      /* Section Headers - Mobile */
      .section-title {
          font-size: 1.8rem;
          margin-bottom: 1rem;
      }
      
      .section-subtitle {
          font-size: 0.95rem;
          margin-bottom: 1.5rem;
      }
      
      /* Category Cards - Mobile - Better Layout */
      .category-card {
          height: 180px;
          border-radius: 10px;
          margin-bottom: 0.8rem;
      }
      
      .category-image {
          height: 110px;
      }
      
      .category-info {
          padding: 12px;
          height: 70px;
      }
      
      .category-info h5 {
          font-size: 0.95rem;
          margin-bottom: 4px;
      }
      
      .product-count {
          font-size: 0.8rem;
      }
      
      /* Brand Cards - Mobile - Better Layout */
      .featured-brand-card {
          height: 160px;
          border-radius: 10px;
          margin-bottom: 0.8rem;
      }
      
      .featured-brand-placeholder {
          font-size: 1.3rem;
      }
      
      .featured-brand-card-title {
          font-size: 0.95rem;
      }
      
      .featured-brand-card-subtitle {
          font-size: 0.8rem;
      }
      
      /* Grid Adjustments */
      .row.g-3 {
          --bs-gutter-x: 0.8rem;
          --bs-gutter-y: 0.8rem;
      }
  }

  /* Extra Small Mobile Devices */
  @media (max-width: 480px) {
      /* Section Headers */
      .section-title {
          font-size: 1.6rem;
          margin-bottom: 0.8rem;
      }
      
      .section-subtitle {
          font-size: 0.9rem;
          margin-bottom: 1rem;
      }
      
      /* Category Cards - Extra Small - Compact */
      .category-card {
          height: 160px;
          border-radius: 8px;
      }
      
      .category-image {
          height: 100px;
      }
      
      .category-info {
          padding: 10px;
          height: 60px;
      }
      
      .category-info h5 {
          font-size: 0.9rem;
          margin-bottom: 3px;
      }
      
      .product-count {
          font-size: 0.75rem;
      }
      
      /* Brand Cards - Extra Small - Compact */
      .featured-brand-card {
          height: 140px;
          border-radius: 8px;
      }
      
      .featured-brand-placeholder {
          font-size: 1.1rem;
      }
      
      .featured-brand-card-title {
          font-size: 0.9rem;
      }
      
      .featured-brand-card-subtitle {
          font-size: 0.75rem;
      }
      
      /* Container Padding */
      .container {
          padding-left: 10px;
          padding-right: 10px;
      }
  }

  /* Landscape Mobile */
  @media (max-width: 768px) and (orientation: landscape) {
      .category-card {
          height: 160px;
      }
      
      .category-image {
          height: 100px;
      }
      
      .featured-brand-card {
          height: 140px;
      }
  }

  /* Touch Device Optimizations */
  @media (hover: none) and (pointer: coarse) {
      .category-card:hover {
          transform: none;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      }
      
      .featured-brand-card:hover {
          transform: none;
          box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      }
      
      .category-card:active {
          transform: scale(0.95);
      }
      
      .featured-brand-card:active {
          transform: scale(0.95);
      }
  }

  /* Simple Mobile Responsive */
  @media (max-width: 768px) {
      .hero-title {
          font-size: 2.5rem;
      }
      
      .hero-subtitle {
          font-size: 1.2rem;
      }
      
      .hero-buttons {
          flex-direction: column;
          align-items: flex-start;
      }
      
      .section-title {
          font-size: 1.8rem;
      }
      
      .cta-title {
          font-size: 2rem;
      }
      
      .cta-section .row {
          text-align: center;
      }
      
      .cta-section .col-lg-4 {
          margin-top: 1rem;
      }
  }
  </style>

  <!-- Testimonials Section -->
  <section class="testimonials-section py-5">
      <div class="container">
          <div class="text-center mb-5">
              <h2 class="section-title">What Our Customers Say</h2>
              <p class="section-subtitle">Real reviews from satisfied customers</p>
          </div>
          <div class="row">
              <?php if($topReviews->count() > 0): ?>
                  <?php $__currentLoopData = $topReviews->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div class="col-lg-4 mb-4">
                          <div class="testimonial-card">
                              <div class="testimonial-content">
                                  <div class="stars">
                                      <?php for($i = 1; $i <= 5; $i++): ?>
                                          <i class="fas fa-star <?php echo e($i <= $review->rating ? 'active' : ''); ?>"></i>
                                      <?php endfor; ?>
                                  </div>
                                  <p>"<?php echo e($review->review); ?>"</p>
                              </div>
                              <div class="testimonial-author">
                                  <div class="author-info">
                                      <h6><?php echo e($review->reviewer_name ?? 'Anonymous'); ?></h6>
                                      <span>Verified Buyer</span>
                                  </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                  <!-- Fallback testimonials if no reviews in database -->
                  <div class="col-lg-4 mb-4">
                      <div class="testimonial-card">
                          <div class="testimonial-content">
                              <div class="stars">
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
        </div>
                              <p>"Amazing quality! My phone survived multiple drops thanks to this case. Highly recommended!"</p>
    </div>
                          <div class="testimonial-author">
                              <div class="author-info">
                                  <h6>Sarah Johnson</h6>
                                  <span>Verified Buyer</span>
</div>
          </div>
      </div>
      </div>
                  <div class="col-lg-4 mb-4">
                      <div class="testimonial-card">
                          <div class="testimonial-content">
                              <div class="stars">
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
                    </div>
                              <p>"Perfect fit and great protection. The design is exactly what I was looking for. Will buy again!"</p>
                        </div>
                          <div class="testimonial-author">
                              <div class="author-info">
                                  <h6>Mike Chen</h6>
                                  <span>Verified Buyer</span>
                    </div>
                </div>
        </div>
    </div>
                  <div class="col-lg-4 mb-4">
                      <div class="testimonial-card">
                          <div class="testimonial-content">
                              <div class="stars">
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
                                  <i class="fas fa-star active"></i>
</div>
                              <p>"Fast shipping and excellent customer service. The case looks great and provides solid protection."</p>
          </div>
                          <div class="testimonial-author">
                              <div class="author-info">
                                  <h6>Emily Davis</h6>
                                  <span>Verified Buyer</span>
      </div>
                          </div>
                      </div>
                  </div>
              <?php endif; ?>
          </div>
      </div>
  </section>

  <!-- Choose Your Model Section -->
  <section class="choose-model-section py-5">
      <div class="container">
          <div class="text-center mb-5">
              <h2 class="choose-model-title">CHOOSE YOUR MODEL</h2>
              <p class="choose-model-subtitle">Select your device brand to find the perfect case</p>
      </div>
          <div class="brands-container">
          <?php if($brands->isNotEmpty()): ?>
                  <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div class="brand-card">
                          <a href="<?php echo e(route('shop.index', ['brand' => $brand->id])); ?>" class="brand-card-link">
                              <div class="brand-icon">
                                  <?php if($brand->image && file_exists(public_path('uploads/brands/' . $brand->image))): ?>
                                  <img src="<?php echo e(asset('uploads/brands/' . $brand->image)); ?>" 
                                       alt="<?php echo e($brand->name); ?>" 
                                           class="brand-icon-image">
                              <?php else: ?>
                                      <span class="brand-icon-letter"><?php echo e(substr($brand->name, 0, 1)); ?></span>
                              <?php endif; ?>
                          </div>
                              <div class="brand-label"><?php echo e($brand->name); ?></div>
                      </a>
                  </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php else: ?>
                  <div class="brand-card">
                      <div class="brand-card-link">
                          <div class="brand-icon">
                              <span class="brand-icon-letter">📱</span>
                          </div>
                          <div class="brand-label">No Brands Available</div>
                  </div>
              </div>
          <?php endif; ?>
          </div>
      </div>
  </section>

  <!-- Call to Action Section -->
  <section class="cta-section py-5 bg-primary text-white">
      <div class="container">
          <div class="row align-items-center">
              <div class="col-lg-8">
                  <h2 class="cta-title">Ready to Protect Your Device?</h2>
                  <p class="cta-description">Join thousands of satisfied customers who trust our premium mobile cases for their device protection needs.</p>
      </div>
              <div class="col-lg-4 text-lg-end">
                  <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-light btn-lg">Shop Now</a>
                                </div>
          </div>
      </div>
  </section>
</main>
<script defer src="<?php echo e(asset('assets/js/banner-slider.js')); ?>"></script>

<style>
/* Modern Mobile Case Website Styles */

  /* Consistent Color Scheme - Same as Global */
  :root {
      --primary-color: #000000;
      --primary-dark: #333333;
      --secondary-color: #6c757d;
      --accent-color: #007bff;
      --success-color: #28a745;
      --warning-color: #ffc107;
      --danger-color: #dc3545;
      --info-color: #17a2b8;
      --dark-color: #343a40;
      --light-color: #f8f9fa;
      --text-primary: #212529;
      --text-secondary: #6c757d;
      --text-muted: #6c757d;
      --bg-light: #f8f9fa;
      --bg-gradient: #000000;
      --bg-gradient-secondary: #333333;
      --bg-gradient-dark: #000000;
      --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.1);
      --shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.15);
      --shadow-heavy: 0 8px 30px rgba(0, 0, 0, 0.2);
      --border-radius: 8px;
      --border-radius-sm: 6px;
      --transition: all 0.3s ease;
  }

/* Global Image Quality Improvements */
img {
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
}

  /* Simple Button Styles */
  .btn-primary {
      background: var(--primary-color);
      border: none;
      border-radius: var(--border-radius-sm);
      font-weight: 600;
      padding: 12px 24px;
      transition: var(--transition);
      box-shadow: var(--shadow-light);
      color: white;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
  }

  .btn-primary:hover {
      background: var(--primary-dark);
      transform: translateY(-1px);
      box-shadow: var(--shadow-medium);
      color: white;
  }

  .btn-outline-primary {
      border: 2px solid var(--primary-color);
      color: var(--primary-color);
      background: transparent;
      border-radius: var(--border-radius-sm);
      font-weight: 600;
      padding: 10px 22px;
      transition: var(--transition);
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
  }

  .btn-outline-primary:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-1px);
      box-shadow: var(--shadow-light);
  }

  /* Simple Section Styling */
  .section-title {
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 1rem;
      position: relative;
      text-align: center;
  }

  .section-title::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 3px;
      background: var(--primary-color);
      border-radius: 2px;
  }

  .section-subtitle {
      font-size: 1rem;
      color: var(--text-secondary);
      margin-bottom: 2rem;
      text-align: center;
      font-weight: 400;
  }

  /* Logo styling now handled globally in layout */

/* Simple Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    overflow: hidden;
}

.hero-slider {
    position: relative;
    height: 100vh;
}

.hero-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1s ease-in-out;
}

.hero-slide.active {
    opacity: 1;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);
}

.hero-content {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    align-items: center;
}

.hero-title {
    font-size: 3.2rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.hero-subtitle {
    font-size: 1.3rem;
    color: #f8f9fa;
    margin-bottom: 1.5rem;
    font-weight: 300;
}

.hero-description {
    font-size: 1rem;
    color: #e9ecef;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.hero-image img {
    max-width: 100%;
    height: auto;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-heavy);
}

.slider-navigation {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
}

.slider-dots {
    display: flex;
    gap: 10px;
}

.slider-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    background: transparent;
    cursor: pointer;
    transition: var(--transition);
}

.slider-dot.active {
    background: #fff;
}

/* Simple Product Cards */
.product-card {
    position: relative;
    margin-bottom: 2rem;
}

.product-card-inner {
    background: #fff;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-light);
    transition: var(--transition);
    height: 100%;
}

.product-card:hover .product-card-inner {
    transform: translateY(-5px);
    box-shadow: var(--shadow-medium);
}

.pc__img-wrapper {
    position: relative;
    overflow: hidden;
    height: 250px;
}

.pc__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: var(--transition);
}

.product-card:hover .pc__img {
    transform: scale(1.05);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition);
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.pc__info {
    padding: 20px;
}

.product-category {
    font-size: 0.8rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}

.pc__title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 12px;
    color: var(--text-primary);
}

.pc__title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition);
}

.pc__title a:hover {
    color: var(--primary-color);
}

.product-features {
    display: flex;
    gap: 6px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}

.feature-tag {
    background: rgba(255, 107, 107, 0.1);
    color: var(--primary-color);
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.product-card__price {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.price-current {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text-primary);
}

.price-new {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--danger-color);
}

.price-old {
    font-size: 0.9rem;
    color: var(--text-muted);
    text-decoration: line-through;
}

.discount-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: var(--danger-color);
    color: #fff;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
}

.sold-out-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: var(--text-muted);
    color: #fff;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
}

/* Simple Categories Section */
.categories-section {
    background: var(--bg-light);
}

/* Simple Testimonials Section */
.testimonials-section {
    background: var(--bg-light);
    padding: 60px 0;
}

.testimonial-card {
    background: #fff;
    padding: 25px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
    height: 100%;
    transition: var(--transition);
    border-left: 4px solid var(--primary-color);
}

.testimonial-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
}

.testimonial-content {
    margin-bottom: 20px;
}

.stars {
    margin-bottom: 15px;
}

.stars i {
    color: #ddd;
    margin-right: 3px;
    transition: var(--transition);
}

.stars i.active {
    color: var(--warning-color);
}

.testimonial-content p {
    font-style: italic;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0;
    font-size: 0.95rem;
}

.testimonial-author {
    display: flex;
    align-items: center;
}

.author-info h6 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--text-primary);
}

.author-info span {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

/* Simple Featured Brands Section */
.featured-brands-section {
    background: var(--bg-light);
}

/* Simple Call to Action Section */
.cta-section {
    background: var(--bg-gradient);
    position: relative;
    overflow: hidden;
}

.cta-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: white;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.cta-description {
    font-size: 1rem;
    margin-bottom: 0;
    opacity: 0.95;
    color: white;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.cta-section .btn-light {
    background: white;
    color: var(--primary-color);
    border: none;
    font-weight: 600;
    padding: 12px 30px;
    border-radius: var(--border-radius-sm);
    transition: var(--transition);
    box-shadow: var(--shadow-light);
}

.cta-section .btn-light:hover {
    background: var(--light-color);
    color: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
}

/* Simple Mobile Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
    }
    
    .hero-buttons {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .cta-title {
        font-size: 2rem;
    }
    
    .cta-section .row {
        text-align: center;
    }
    
    .cta-section .col-lg-4 {
        margin-top: 1rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.slider-dot');
    let currentSlide = 0;
    
    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        slides[index].classList.add('active');
        dots[index].classList.add('active');
    }
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });
    
    // Auto-advance slides every 5 seconds
    setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }, 5000);
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\trakkiez\resources\views/index.blade.php ENDPATH**/ ?>