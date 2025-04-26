@extends("layouts.app")
@section("content")
<style>
  /* Existing styles remain unchanged */
  .section-title {
      font-size: 1.2rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #333;
      margin-bottom: 2rem;
      font-family: 'Roboto';
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
  }

  .section-title a {
      font-size: 0.7rem;
      font-weight: 500;
      color: #666;
      text-decoration: none;
      margin-left: 0.6rem;
      font-family: 'Lora', serif;
      transition: color 0.3s ease;
  }

  .section-title a:hover {
      color: #000;
      text-decoration: underline;
  }

  .pc__img {
      width: 300px;
      height: auto;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .swiper-slide {
      margin-bottom: 2rem;
  }

  .hot-deals,
  .featured-products,
  .new-arrivals {
      margin-top: 3rem;
      margin-bottom: 3rem;
  }

  .sold-out-badge {
      position: absolute;
      bottom: 47px;
      right: 53px;
      background: #ff9800;
      color: #fff;
      font-size: 0.9rem;
      font-weight: bold;
      padding: 4px 8px;
      border-radius: 5px;
      z-index: 10;
  }

  /* Styles for Summer Collection */
  .summer-collection {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 50px 0;
      background: linear-gradient(180deg, #f9f9f9 0%, #ffffff 100%);
      flex-wrap: wrap;
  }

  .summer-collection .image-gallery {
      display: grid;
      grid-template-areas: 
          "img1 img2 img3"
          "img4 img2 img5";
      gap: 10px;
      max-width: 600px;
      margin-right: 40px;
      height: 500px; /* Fixed height for desktop */
  }

  .summer-collection .image-gallery img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .img1 { grid-area: img1; }
  .img2 { grid-area: img2; }
  .img3 { grid-area: img3; }
  .img4 { grid-area: img4; }
  .img5 { grid-area: img5; }

  .summer-collection .text-content {
      max-width: 400px;
      text-align: left;
  }

  .summer-collection .text-content h3 {
      font-size: 14px;
      color: #666;
      text-transform: uppercase;
      margin-bottom: 10px;
      font-family: 'Roboto', sans-serif;
  }

  .summer-collection .text-content h1 {
      font-size: 36px;
      color: #333;
      margin-bottom: 20px;
      font-family: 'Roboto', sans-serif;
      font-weight: 700;
  }

  .summer-collection .text-content p {
      font-size: 16px;
      color: #666;
      margin-bottom: 20px;
      line-height: 1.5;
      font-family: 'Lora', serif;
  }

  .summer-collection .text-content button {
      background-color: #8b3a3a;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 14px;
      text-transform: uppercase;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s;
      font-family: 'Roboto', sans-serif;
  }

  .summer-collection .text-content button:hover {
      background-color: #723131;
  }

  /* Responsive Design for Mobile */
  @media (max-width: 768px) {
      body,
      main {
          padding-top: 0 !important;
          margin-top: 0 !important;
      }

      .trakkiez-main-banner-section {
          margin-top: 0 !important;
          padding-top: 0 !important;
      }

      .header-mobile {
          position: relative !important;
      }

      .top-bar {
          position: fixed !important;
          top: 0;
          left: 0;
          width: 100%;
          z-index: 1000;
      }

      .banner-slider {
          margin-top: 0;
      }

      .banner-slide {
          margin-top: 0;
      }

      .swiper-container {
          padding-top: 0;
          margin-top: 0;
      }

      .swiper-slide {
          height: 380px;
      }

      .slideshow-character {
          padding-bottom: 20px;
      }

      .slideshow-character img {
          width: 100%;
          height: auto;
      }

      .slideshow-text {
          top: 50% !important;
          margin-top: 20px;
      }

      .slideshow-text h2 {
          font-size: 1.5rem;
          margin-bottom: 10px;
      }

      .slideshow-text a {
          font-size: 1rem;
      }

      .slideshow-pagination {
          bottom: 20px;
      }

      /* Summer Collection Mobile Adjustments */
      .summer-collection {
          display: block; /* Ensure block layout for vertical stacking */
          text-align: center;
          padding: 30px 15px;
      }

      .summer-collection .image-gallery {
          display: grid;
          grid-template-areas: 
              "img1 img2 img3"
              "img4 img2 img5";
          gap: 5px;
          max-width: 100%;
          width: 100%;
          height: 100px; /* Reduced height for mobile */
          margin: 0 auto 40px; /* Center and add bottom margin */
      }

      .summer-collection .image-gallery img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .summer-collection .text-content {
          display: block; /* Ensure block layout */
          max-width: 100%;
          padding: 0 20px;
          text-align: center;
          margin-top: 260px; /* Ensure text is below the gallery by adding top margin */
      }

      .summer-collection .text-content h3 {
          font-size: 12px;
      }

      .summer-collection .text-content h1 {
          font-size: 24px;
          margin-bottom:10px;
      }

      .summer-collection .text-content p {
          font-size: 14px;
          margin-bottom:5px;
      }

      .summer-collection .text-content button {
          padding: 8px 16px;
          font-size: 12px;
      }
  }

  @media (min-width: 769px) {
      body,
      main {
          padding-top: 0 !important;
      }

      .header {
          position: relative !important;
      }

      .trakkiez-main-banner-section {
          margin-top: 0;
      }
  }

  .man-category {
      background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
      padding: 23px 0;
  }

  .woman-category {
      background: linear-gradient(180deg, #fff5f5 0%, #ffffff 100%);
      padding: 23px 0;
  }

  .new-arrivals {
      background: linear-gradient(180deg, #e8ecef 0%, #ffffff 100%);
      padding: 23px 0;
  }
</style>

<main>
  <!-- Banner Slider Section -->
  <div class="trakkiez-main-banner-section">
      <div class="trakkiez-banner-wrapper">
          <div class="banner-slider">
              @foreach($slides as $index => $slide)
                  <div class="banner-slide {{ $index === 0 ? 'active' : '' }}">
                      <img src="{{ asset('uploads/slides/' . $slide->image) }}" alt="Banner {{ $index + 1 }}" class="trakkiez-banner-image">
                  </div>
              @endforeach

              <div class="slider-dots">
                  @foreach($slides as $index => $slide)
                      <div class="slider-dot {{ $index === 0 ? 'active' : '' }}"></div>
                  @endforeach
              </div>
          </div>
          <div class="static-content-box">
              <h3 class="static-title">Elegant Collection</h3>
              <p class="static-subtitle">Discover Timeless Style and Sophistication</p>
              <a href="/shop" class="static-button">Shop Now</a>
          </div>
      </div>
  </div>

  <!-- Summer Collection Section -->
  <section class="summer-collection container mt-5">
      <div class="image-gallery">
          <div class="img1">
              <img src="{{ asset('assets/images/main/ahsan.jpg') }}" alt="Summer 1">
          </div>
          <div class="img2">
              <img src="{{ asset('assets/images/main/ahsan.jpg') }}" alt="Summer 2">
          </div>
          <div class="img3">
              <img src="{{ asset('assets/images/main/ahsan.jpg') }}" alt="Summer 3">
          </div>
          <div class="img4">
              <img src="{{ asset('assets/images/main/ahsan.jpg') }}" alt="Summer 4">
          </div>
          <div class="img5">
              <img src="{{ asset('assets/images/main/ahsan.jpg') }}" alt="Summer 5">
          </div>
      </div>
      <div class="text-content">
          <h3>ALL NEW SUMMER COLLECTION</h3>
          <h1>Upto 20% OFF</h1>
          <p>Hurry up! Don’t miss the opportunity to get amazing designs and premium quality stuff for this latest summer collection.</p>
          <button onclick="window.location.href='{{ route('shop.index', ['filter' => 'summer-collection']) }}'">NEW SUMMER COLLECTION</button>
      </div>
  </section>

  <!-- New Arrivals Section -->
  <section class="new-arrivals container mt-5">
      <div class="text-center mb-4">
          <h2 class="section-title">New Arrivals <a href="{{ route('shop.index', ['filter' => 'new-arrivals']) }}">(View All)</a></h2>
      </div>
      <div class="row">
          <div class="col-12">
              <div class="position-relative">
                  <div class="swiper-container js-swiper-slider" data-settings='{
                      "autoplay": { "delay": 1500 },
                      "slidesPerView": 4,
                      "slidesPerGroup": 4,
                      "effect": "none",
                      "loop Definition: false,
                      "breakpoints": {
                          "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 14 },
                          "768": { "slidesPerView": 2, "slidesPerGroup": 3, "spaceBetween": 24 },
                          "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 30 },
                          "1200": { "slidesPerView": 4, "slidesPerGroup": 1, "spaceBetween": 30 }
                      }
                  }'>
                      <div class="swiper-wrapper">
                          @foreach($newArrivals as $product)
                              <div class="swiper-slide product-card product-card_style3" style="position: relative;">
                                  <div class="pc__img-wrapper">
                                      <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                          <img loading="lazy" src="{{ asset('uploads/products/' . $product->image) }}" width="200" height="auto" alt="{{ $product->name }}" class="pc__img">
                                      </a>
                                      @if($product->quantity <= 0)
                                          <div class="sold-out-badge">Sold Out</div>
                                      @endif
                                  </div>
                                  <div class="pc__info position-relative">
                                      <h6 class="pc__title">
                                          <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                              {{ $product->name }}
                                          </a>
                                      </h6>
                                      <div class="product-card__price d-flex">
                                          <span class="money price text-secondary">
                                              @if($product->sale_price)
                                                  <s>PKR {{ $product->regular_price }}</s> PKR {{ $product->sale_price }}
                                              @else
                                                  PKR {{ $product->regular_price }}
                                              @endif
                                          </span>
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

  <!-- Man Category Section -->
  <section class="man-category container mt-5">
      <div class="text-center mb-4">
          <h2 class="section-title">Men's Collection <a href="{{ route('home.category', ['category_slug' => 'men']) }}">(View All)</a></h2>
      </div>
      <div class="row">
          <div class="col-12">
              <div class="position-relative">
                  <div class="swiper-container js-swiper-slider" data-settings='{
                      "autoplay": { "delay": 1500 },
                      "slidesPerView": 4,
                      "slidesPerGroup": 4,
                      "effect": "none",
                      "loop": false,
                      "breakpoints": {
                          "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 14 },
                          "768": { "slidesPerView": 2, "slidesPerGroup": 3, "spaceBetween": 24 },
                          "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 30 },
                          "1200": { "slidesPerView": 4, "slidesPerGroup": 1, "spaceBetween": 30 }
                      }
                  }'>
                      <div class="swiper-wrapper">
                          @if($manCategory && $manCategory->products->isNotEmpty())
                              @foreach($manCategory->products as $product)
                                  <div class="swiper-slide product-card product-card_style3" style="position: relative;">
                                      <div class="pc__img-wrapper">
                                          <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                              <img loading="lazy" src="{{ asset('uploads/products/' . $product->image) }}" width="200" height="auto" alt="{{ $product->name }}" class="pc__img">
                                          </a>
                                          @if($product->quantity <= 0)
                                              <div class="sold-out-badge">Sold Out</div>
                                          @endif
                                      </div>
                                      <div class="pc__info position-relative">
                                          <h6 class="pc__title">
                                              <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                  {{ $product->name }}
                                              </a>
                                          </h6>
                                          <div class="product-card__price d-flex">
                                              <span class="money price text-secondary">
                                                  @if($product->sale_price)
                                                      <s>PKR {{ $product->regular_price }}</s> PKR {{ $product->sale_price }}
                                                  @else
                                                      PKR {{ $product->regular_price }}
                                                  @endif
                                              </span>
                                          </div>
                                      </div>
                                  </div>
                              @endforeach
                          @else
                              <p>No products available for this category.</p>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>

  <!-- Woman Category Section -->
  <section class="woman-category container mt-5">
      <div class="text-center mb-4">
          <h2 class="section-title">Women's Collection <a href="{{ route('home.category', ['category_slug' => 'women']) }}">(View All)</a></h2>
      </div>
      <div class="row">
          <div class="col-12">
              <div class="position-relative">
                  <div class="swiper-container js-swiper-slider" data-settings='{
                      "autoplay": { "delay": 1500 },
                      "slidesPerView": 4,
                      "slidesPerGroup": 4,
                      "effect": "none",
                      "loop": false,
                      "breakpoints": {
                          "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 14 },
                          "768": { "slidesPerView": 2, "slidesPerGroup": 3, "spaceBetween": 24 },
                          "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 30 },
                          "1200": { "slidesPerView": 4, "slidesPerGroup": 1, "spaceBetween": 30 }
                      }
                  }'>
                      <div class="swiper-wrapper">
                          @if($womenCategory && $womenCategory->products->isNotEmpty())
                              @foreach($womenCategory->products as $product)
                                  <div class="swiper-slide product-card product-card_style3" style="position: relative;">
                                      <div class="pc__img-wrapper">
                                          <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                              <img loading="lazy" src="{{ asset('uploads/products/' . $product->image) }}" width="200" height="auto" alt="{{ $product->name }}" class="pc__img">
                                          </a>
                                          @if($product->quantity <= 0)
                                              <div class="sold-out-badge">Sold Out</div>
                                          @endif
                                      </div>
                                      <div class="pc__info position-relative">
                                          <h6 class="pc__title">
                                              <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                  {{ $product->name }}
                                              </a>
                                          </h6>
                                          <div class="product-card__price d-flex">
                                              <span class="money price text-secondary">
                                                  @if($product->sale_price)
                                                      <s>PKR {{ $product->regular_price }}</s> PKR {{ $product->sale_price }}
                                                  @else
                                                      PKR {{ $product->regular_price }}
                                                  @endif
                                              </span>
                                          </div>
                                      </div>
                                  </div>
                              @endforeach
                          @else
                              <p>No products available for this category.</p>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Banner Slider Script (Existing)
    let currentSlide = 0;
    const slides = document.querySelectorAll('.banner-slide');
    const dots = document.querySelectorAll('.slider-dot');
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.forEach(slide => {
            slide.classList.remove('active');
            slide.style.opacity = '0';
        });
        slides[index].classList.add('active');
        slides[index].style.opacity = '1';

        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });

    setInterval(nextSlide, 5000);
});
</script>
@endsection