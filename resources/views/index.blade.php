@extends("layouts.app")
@section("content")
<main>
  <!-- Hero Section -->
  <section class="hero-section">
      <div class="hero-slider">
              @foreach($slides as $index => $slide)
              <div class="hero-slide {{ $index === 0 ? 'active' : '' }}">
                  <div class="hero-background" style="background-image: url('{{ asset('uploads/slides/' . $slide->image) }}')"></div>
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
                                          <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">Shop Now</a>
                                          <a href="#featured-products" class="btn btn-outline-light btn-lg">View Collection</a>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="hero-image">
                                      <img src="{{ asset('uploads/slides/' . $slide->image) }}" alt="Premium Mobile Cases" class="img-fluid">
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  </div>
              @endforeach
      </div>

      <!-- Slider Navigation -->
      <div class="slider-navigation">
              <div class="slider-dots">
                  @foreach($slides as $index => $slide)
                  <button class="slider-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></button>
                  @endforeach
              </div>
          </div>
  </section>

  <!-- Features Section -->
  <!-- <section class="features-section py-5">
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
  </section> -->

  <!-- Featured Products Section -->
  <section id="featured-products" class="featured-products-section py-5">
      <div class="container">
          <div class="text-center mb-5">
              <h2 class="section-title">Featured Mobile Cases</h2>
              <p class="section-subtitle">Discover our most popular and trending mobile case designs</p>
              <a href="{{ route('shop.index', ['filter' => 'new-arrivals']) }}" class="btn btn-outline-primary">View All Products</a>
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
            @foreach($newArrivals as $product)
                <div class="swiper-slide product-card">
                    <div class="product-card-inner">
                    <div class="pc__img-wrapper">
                        <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                            <img class="swiper-lazy pc__img" 
                                     data-srcset="{{asset('uploads/products/' . $product->main_image) }} 600w, {{ asset('uploads/products/thumbnails/' . $product->main_image) }} 300w"
                                     data-sizes="(max-width: 576px) 300px, 600px"
                                 data-src="{{asset('uploads/products/thumbnails/' . $product->main_image) }}" 
                                     alt="{{ $product->name }} mobile case"
                                     width="600" height="600"
                                     loading="lazy">
                            <div class="swiper-lazy-preloader"></div>
                        </a>
                        @if($product->sale_price && $product->regular_price)
                            @php
                                $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                            @endphp
                            <div class="discount-badge">SAVE {{ $discount }}%</div>
                        @endif
                        @if($product->stock_status === 'out_of_stock')
                            <div class="sold-out-badge">Sold Out</div>
                        @endif
                            <div class="product-overlay">
                                <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}" class="btn btn-primary btn-sm">View Details</a>
                            </div>
                    </div>
                    <div class="pc__info">
                            <div class="product-category">{{ $product->category->name ?? 'Mobile Case' }}</div>
                        <h6 class="pc__title">
                            <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                {{ $product->name }}
                            </a>
                        </h6>
                            <div class="product-features">
                                <span class="feature-tag">Shockproof</span>
                                <span class="feature-tag">Scratch Resistant</span>
                            </div>
                        <div class="product-card__price">
                            @if($product->sale_price)
                                    <span class="price-old">PKR {{ $product->regular_price }}</span>
                                    <span class="price-new">PKR {{ $product->sale_price }}</span>
                            @else
                                    <span class="price-current">PKR {{ $product->regular_price }}</span>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
          <div class="row g-3">
              @if(isset($categories) && $categories->isNotEmpty())
                  @foreach($categories->take(6) as $category)
                      <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                          <a href="{{ route('home.category', ['category_slug' => $category->slug]) }}" class="category-card">
                              <div class="category-image">
                                  @if($category->image && file_exists(public_path('uploads/categories/' . $category->image)))
                                      <img src="{{ asset('uploads/categories/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid">
                                  @elseif($category->products->count() > 0)
                                      <img src="{{ asset('uploads/products/thumbnails/' . $category->products->first()->main_image) }}" 
                                           alt="{{ $category->name }}" class="img-fluid">
                                  @else
                                      <div class="category-placeholder">
                                          <i class="fas fa-mobile-alt"></i>
                                      </div>
                                  @endif
                              </div>
                              <div class="category-info">
                                  <h5>{{ $category->name }}</h5>
                                  <span class="product-count">{{ $category->products_count ?? $category->products->count() }} Products</span>
                              </div>
                          </a>
                      </div>
                  @endforeach
              @else
                  <div class="col-12">
                      <div class="text-center py-5">
                          <i class="fas fa-th-large text-muted" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                          <p class="text-muted fs-5">No Categories Available</p>
                      </div>
                  </div>
              @endif
          </div>
      </div>
  </section>

  <style>
  /* Beautiful Category Cards - Enhanced Design */
  .category-card {
      height: 280px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      text-decoration: none;
      color: inherit;
      position: relative;
      background: #fff;
      border: 3px solid transparent;
  }

  .category-card:hover {
      transform: translateY(-15px) scale(1.03);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
      text-decoration: none;
      color: inherit;
      border-color: #667eea;
  }

  .category-image {
      height: 200px;
      width: 100%;
      overflow: hidden;
      position: relative;
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  }

  .category-image::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
      z-index: 1;
      transition: opacity 0.5s ease;
  }

  .category-card:hover .category-image::before {
      opacity: 0.3;
  }

  .category-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      transition: transform 0.5s ease;
      position: relative;
      z-index: 2;
      filter: brightness(1.05) contrast(1.05);
      min-height: 100%;
      min-width: 100%;
  }

  .category-card:hover .category-image img {
      transform: scale(1.1);
      filter: brightness(1.15) contrast(1.15);
  }

  .category-placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      font-size: 3rem;
      position: relative;
      z-index: 2;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .category-info {
      padding: 25px;
      background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
      height: 80px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
  }

  .category-info::before {
      content: '';
      position: absolute;
      top: 0;
      left: 25px;
      right: 25px;
      height: 2px;
      background: linear-gradient(90deg, transparent 0%, #667eea 50%, transparent 100%);
      border-radius: 1px;
  }

  .category-info h5 {
      font-size: 1.2rem;
      font-weight: 700;
      margin: 0 0 10px 0;
      color: #2c3e50;
      line-height: 1.3;
      letter-spacing: 0.5px;
  }

  .product-count {
      font-size: 1rem;
      color: #6c757d;
      font-weight: 600;
      background: linear-gradient(135deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
  }

  /* Beautiful Brand Cards - Full Coverage */
  .featured-brand-card {
      height: 250px;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      text-decoration: none;
      color: inherit;
      position: relative;
      background: #fff;
      border: 2px solid transparent;
  }

  .featured-brand-card:hover {
      transform: translateY(-12px) scale(1.02);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      text-decoration: none;
      color: inherit;
      border-color: #667eea;
  }

  .featured-brand-card-image {
      height: 100%;
      width: 100%;
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  }

  .featured-brand-card-image::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
      z-index: 1;
      transition: opacity 0.5s ease;
  }

  .featured-brand-card:hover .featured-brand-card-image::before {
      opacity: 0.3;
  }

  .featured-brand-logo {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      transition: transform 0.5s ease;
      position: relative;
      z-index: 2;
      filter: brightness(1.1) contrast(1.1);
      min-height: 100%;
      min-width: 100%;
  }

  .featured-brand-card:hover .featured-brand-logo {
      transform: scale(1.1);
      filter: brightness(1.2) contrast(1.2);
  }

  .featured-brand-placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      font-size: 2rem;
      font-weight: 800;
      position: relative;
      z-index: 2;
      text-align: center;
      padding: 2rem;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .featured-brand-card-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.6) 50%, transparent 100%);
      color: white;
      padding: 25px;
      transform: translateY(100%);
      transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      z-index: 3;
  }

  .featured-brand-card:hover .featured-brand-card-overlay {
      transform: translateY(0);
  }

  .featured-brand-card-title {
      font-size: 1.3rem;
      font-weight: 800;
      margin: 0 0 10px 0;
      text-shadow: 0 2px 4px rgba(0,0,0,0.5);
      letter-spacing: 0.5px;
  }

  .featured-brand-card-subtitle {
      font-size: 1rem;
      margin: 0;
      opacity: 0.95;
      font-weight: 600;
      text-shadow: 0 1px 2px rgba(0,0,0,0.5);
  }

  /* Section Styling */
  .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 1rem;
      position: relative;
  }

  .section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
      border-radius: 2px;
  }

  .section-subtitle {
      font-size: 1.1rem;
      color: #6c757d;
      margin-bottom: 0;
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

  /* Animation for cards on scroll */
  .category-card, .featured-brand-card {
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.6s ease forwards;
  }

  .category-card:nth-child(1) { animation-delay: 0.1s; }
  .category-card:nth-child(2) { animation-delay: 0.2s; }
  .category-card:nth-child(3) { animation-delay: 0.3s; }
  .category-card:nth-child(4) { animation-delay: 0.4s; }
  .category-card:nth-child(5) { animation-delay: 0.5s; }
  .category-card:nth-child(6) { animation-delay: 0.6s; }

  .featured-brand-card:nth-child(1) { animation-delay: 0.1s; }
  .featured-brand-card:nth-child(2) { animation-delay: 0.2s; }
  .featured-brand-card:nth-child(3) { animation-delay: 0.3s; }
  .featured-brand-card:nth-child(4) { animation-delay: 0.4s; }
  .featured-brand-card:nth-child(5) { animation-delay: 0.5s; }
  .featured-brand-card:nth-child(6) { animation-delay: 0.6s; }

  @keyframes fadeInUp {
      to {
          opacity: 1;
          transform: translateY(0);
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
              @if($topReviews->count() > 0)
                  @foreach($topReviews->take(3) as $review)
                      <div class="col-lg-4 mb-4">
                          <div class="testimonial-card">
                              <div class="testimonial-content">
                                  <div class="stars">
                                      @for($i = 1; $i <= 5; $i++)
                                          <i class="fas fa-star {{ $i <= $review->rating ? 'active' : '' }}"></i>
                                      @endfor
                                  </div>
                                  <p>"{{ $review->review }}"</p>
                              </div>
                              <div class="testimonial-author">
                                  <div class="author-info">
                                      <h6>{{ $review->reviewer_name ?? 'Anonymous' }}</h6>
                                      <span>Verified Buyer</span>
                                  </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @else
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
              @endif
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
      <div class="row g-3">
          @if($brands->isNotEmpty())
              @foreach($brands->take(6) as $brand)
                  <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                      <a href="{{ route('shop.index', ['brand' => $brand->id]) }}" class="featured-brand-card">
                          <div class="featured-brand-card-image">
                              @if($brand->image && file_exists(base_path('uploads/brands/' . $brand->image)))
                                  <img src="{{ asset('uploads/brands/' . $brand->image) }}" 
                                       alt="{{ $brand->name }}" 
                                       class="featured-brand-logo">
                              @else
                                  <div class="featured-brand-placeholder">
                                      <span>{{ $brand->name }}</span>
                                  </div>
                              @endif
                          </div>
                          <div class="featured-brand-card-overlay">
                              <h3 class="featured-brand-card-title">{{ $brand->name }}</h3>
                              <p class="featured-brand-card-subtitle">Explore {{ $brand->name }} Collection</p>
                          </div>
                      </a>
                  </div>
              @endforeach
          @else
              <div class="col-12">
                  <div class="text-center py-5">
                      <i class="fas fa-store-alt text-muted" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                      <p class="text-muted fs-5">No Brands Available</p>
                  </div>
              </div>
          @endif
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
                  <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg">Shop Now</a>
                                </div>
          </div>
      </div>
  </section>
</main>
<script defer src="{{ asset('assets/js/banner-slider.js') }}"></script>

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
@endsection

@push('scripts')
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
@endpush