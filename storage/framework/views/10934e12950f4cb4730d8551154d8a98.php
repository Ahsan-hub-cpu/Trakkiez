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

  <!-- Features Section -->
  <section class="features-section py-5">
      <div class="container">
          <div class="row">
              <div class="col-lg-3 col-md-6 mb-4">
                  <div class="feature-card text-center">
                      <div class="feature-icon">
                          <i class="fas fa-shield-alt"></i>
          </div>
                      <h4>Maximum Protection</h4>
                      <p>Military-grade protection against drops, scratches, and daily wear</p>
      </div>
  </div>
              <div class="col-lg-3 col-md-6 mb-4">
                  <div class="feature-card text-center">
                      <div class="feature-icon">
                          <i class="fas fa-mobile-alt"></i>
    </div>
                      <h4>Perfect Fit</h4>
                      <p>Precisely designed for your specific phone model with easy access to all ports</p>
    </div>
              </div>
              <div class="col-lg-3 col-md-6 mb-4">
                  <div class="feature-card text-center">
                      <div class="feature-icon">
                          <i class="fas fa-palette"></i>
                      </div>
                      <h4>Stylish Design</h4>
                      <p>Choose from a wide variety of colors and patterns to match your style</p>
                  </div>
              </div>
              <div class="col-lg-3 col-md-6 mb-4">
                  <div class="feature-card text-center">
                      <div class="feature-icon">
                          <i class="fas fa-shipping-fast"></i>
                      </div>
                      <h4>Fast Shipping</h4>
                      <p>Free shipping on orders over $50 with delivery in 2-3 business days</p>
                  </div>
              </div>
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

  <!-- Categories Section -->
  <section class="categories-section py-5 bg-light">
      <div class="container">
          <div class="text-center mb-5">
              <h2 class="section-title">Shop by Category</h2>
              <p class="section-subtitle">Find the perfect case for your device</p>
      </div>
          <div class="row">
              <?php if(isset($categories) && $categories->isNotEmpty()): ?>
                  <?php $__currentLoopData = $categories->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                          <a href="<?php echo e(route('home.category', ['category_slug' => $category->slug])); ?>" class="category-card">
                              <div class="category-image">
                                  <?php if($category->image && file_exists(public_path('uploads/categories/' . $category->image))): ?>
                                      <img src="<?php echo e(asset('uploads/categories/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>" class="img-fluid"
                                           style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges; -webkit-backface-visibility: hidden; backface-visibility: hidden; -webkit-transform: translateZ(0); transform: translateZ(0);">
                                  <?php elseif($category->products->count() > 0): ?>
                                      <img src="<?php echo e(asset('uploads/products/thumbnails/' . $category->products->first()->main_image)); ?>" 
                                           alt="<?php echo e($category->name); ?>" class="img-fluid"
                                           style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges; -webkit-backface-visibility: hidden; backface-visibility: hidden; -webkit-transform: translateZ(0); transform: translateZ(0);">
                                  <?php else: ?>
                                      <div class="category-placeholder">
                                          <i class="fas fa-mobile-alt"></i>
                                      </div>
                        <?php endif; ?>
                    </div>
                              <div class="category-info">
                                  <h5><?php echo e($category->name); ?></h5>
                                  <span class="product-count"><?php echo e($category->products_count ?? $category->products->count()); ?> Products</span>
                              </div>
                          </a>
                      </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
          </div>
      </div>
  </section>

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

  <!-- Featured Brands Section -->
  <section class="featured-brands-section py-5">
      <div class="container">
          <div class="text-center mb-5">
              <h2 class="section-title">Trusted Brands</h2>
              <p class="section-subtitle">Premium mobile case manufacturers</p>
      </div>
      <div class="row">
          <?php if($brands->isNotEmpty()): ?>
              <?php $__currentLoopData = $brands->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                      <a href="<?php echo e(route('shop.index', ['brand' => $brand->id])); ?>" class="featured-brand-card">
                          <div class="featured-brand-card-image">
                              <?php if($brand->image && file_exists(base_path('uploads/brands/' . $brand->image))): ?>
                                  <img src="<?php echo e(asset('uploads/brands/' . $brand->image)); ?>" 
                                       alt="<?php echo e($brand->name); ?>" 
                                       class="featured-brand-logo">
                              <?php else: ?>
                                  <div class="featured-brand-placeholder">
                                      <span><?php echo e($brand->name); ?></span>
                                  </div>
                              <?php endif; ?>
                          </div>
                          <div class="featured-brand-card-overlay">
                              <h3 class="featured-brand-card-title"><?php echo e($brand->name); ?></h3>
                              <p class="featured-brand-card-subtitle">Explore <?php echo e($brand->name); ?> Collection</p>
                          </div>
                      </a>
                  </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php else: ?>
              <div class="col-12">
                  <p class="text-center text-muted">No Brands Available</p>
              </div>
          <?php endif; ?>
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

/* Global Image Quality Improvements */
img {
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
}

/* Hero Section */
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
    font-size: 3.5rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.hero-subtitle {
    font-size: 1.5rem;
    color: #f8f9fa;
    margin-bottom: 1.5rem;
    font-weight: 300;
}

.hero-description {
    font-size: 1.1rem;
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
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
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
    transition: all 0.3s ease;
}

.slider-dot.active {
    background: #fff;
}

/* Features Section */
.features-section {
    background: #f8f9fa;
}

.feature-card {
    background: #fff;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: #fff;
}

.feature-card h4 {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #2d3436;
}

.feature-card p {
    color: #636e72;
    line-height: 1.6;
    margin: 0;
}

/* Section Titles */
.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3436;
    margin-bottom: 1rem;
    text-align: center;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #636e72;
    text-align: center;
    margin-bottom: 2rem;
}

/* Product Cards */
.product-card {
    position: relative;
    margin-bottom: 2rem;
}

.product-card-inner {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.product-card:hover .product-card-inner {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.pc__img-wrapper {
    position: relative;
    overflow: hidden;
    height: 300px;
}

.pc__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.3s ease;
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    image-rendering: pixelated;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
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
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.pc__info {
    padding: 1.5rem;
}

.product-category {
    font-size: 0.9rem;
    color: #636e72;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.pc__title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #2d3436;
}

.pc__title a {
    color: #2d3436;
    text-decoration: none;
    transition: color 0.3s ease;
}

.pc__title a:hover {
    color: #667eea;
}

.product-features {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.feature-tag {
    background: #e3f2fd;
    color: #1976d2;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.product-card__price {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.price-current {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3436;
}

.price-new {
    font-size: 1.3rem;
    font-weight: 700;
    color: #e74c3c;
}

.price-old {
        font-size: 1rem;
    color: #95a5a6;
    text-decoration: line-through;
}

.discount-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #e74c3c;
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    z-index: 2;
    }

    .sold-out-badge {
    position: absolute;
    top: 15px;
        right: 15px;
    background: #95a5a6;
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 20px;
        font-size: 0.9rem;
    font-weight: 600;
    z-index: 2;
}

/* Categories Section */
.categories-section {
    background: #f8f9fa;
}

.category-card {
    display: block;
    text-decoration: none;
    color: inherit;
    transition: transform 0.3s ease;
}

.category-card:hover {
    text-decoration: none;
    color: inherit;
    transform: translateY(-5px);
}

.category-image {
    height: 150px;
    background: #fff;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    overflow: hidden;
}

.category-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.category-placeholder {
    font-size: 3rem;
    color: #636e72;
}

.category-info h5 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2d3436;
}

.product-count {
        font-size: 0.9rem;
    color: #636e72;
}

/* Testimonials Section */
.testimonial-card {
    background: #fff;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    height: 100%;
    transition: transform 0.3s ease;
}

.testimonial-card:hover {
    transform: translateY(-5px);
}

.testimonial-content {
    margin-bottom: 1.5rem;
}

.stars {
    margin-bottom: 1rem;
}

.stars i {
    color: #ddd;
    margin-right: 2px;
    transition: color 0.2s ease;
}

.stars i.active {
    color: #f39c12;
}

.testimonial-content p {
    font-style: italic;
    color: #636e72;
    line-height: 1.6;
    margin: 0;
}

.testimonial-author {
        display: flex;
        align-items: center;
}

.author-info h6 {
        font-size: 1rem;
        font-weight: 600;
    margin-bottom: 0.25rem;
        color: #2d3436;
    }

.author-info span {
    font-size: 0.9rem;
    color: #636e72;
    }

/* Featured Brands Section */
    .featured-brands-section {
    background: #f8f9fa;
    }

    .featured-brand-card {
        display: block;
        text-decoration: none;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        background: #fff;
        margin-bottom: 30px;
        height: 250px;
    }

    .featured-brand-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .featured-brand-card-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        position: relative;
    }

    .featured-brand-logo {
        max-width: 80%;
        max-height: 80%;
        object-fit: contain;
        filter: grayscale(100%);
        transition: filter 0.3s ease;
    }

    .featured-brand-card:hover .featured-brand-logo {
        filter: grayscale(0%);
    }

    .featured-brand-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        text-align: center;
    }

    .featured-brand-card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
        padding: 20px;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }

    .featured-brand-card:hover .featured-brand-card-overlay {
        transform: translateY(0);
    }

    .featured-brand-card-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: white;
    }

    .featured-brand-card-subtitle {
        font-size: 1rem;
        margin: 0;
        color: rgba(255, 255, 255, 0.9);
    }

/* Call to Action Section */
.cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-description {
    font-size: 1.1rem;
    margin-bottom: 0;
    opacity: 0.9;
}

/* Responsive Design */
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
        font-size: 2rem;
    }
    
    .feature-card {
        padding: 1.5rem;
    }
    
    .product-card-inner {
        margin-bottom: 1rem;
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