@extends("layouts.app")
@section("content")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<style>
  /* Existing styles with hover functionality restored */
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

  .sold-out-badge {
      position: absolute;
      bottom: 20px;
      right: 20px;
      background: #ff5722;
      color: #fff;
      font-size: 0.9rem;
      font-weight: 600;
      padding: 6px 12px;
      border-radius: 5px;
      text-transform: uppercase;
      z-index: 10;
  }

  .discount-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background: #ff0000;
      color: #fff;
      font-size: 0.9rem;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 3px;
      text-transform: uppercase;
      z-index: 10;
  }

  .summer-collection {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 50px 0;
      background: none;
  }

  .summer-collection .image-gallery {
      display: grid;
      grid-template-areas: 
          "img1 img2 img3"
          "img4 img2 img5";
      gap: 10px;
      max-width: 600px;
      margin-right: 40px;
      height: 500px;
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

  .new-arrivals .section-title,
  .man-category .section-title,
  .woman-category .section-title {
      font-size: 1.8rem;
      font-weight: 600;
      color: #2d3436;
      margin-bottom: 30px;
      position: relative;
      text-transform: uppercase;
      letter-spacing: 2px;
      font-family: 'Lora', serif;
      text-shadow: none;
  }

  .new-arrivals .section-title::after,
  .man-category .section-title::after,
  .woman-category .section-title::after {
      content: '';
      width: 60px;
      height: 4px;
      background: linear-gradient(to right, #ff6b6b, #feca57);
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
  }

  .new-arrivals .section-title a,
  .man-category .section-title a,
  .woman-category .section-title a {
      font-size: 0.8rem;
      font-weight: 500;
      color: #666;
      margin-left: 1rem;
      font-family: 'Poppins', sans-serif;
  }

  .new-arrivals .section-title a:hover,
  .man-category .section-title a:hover,
  .woman-category .section-title a:hover {
      color: #ff6b6b;
  }

  .new-arrivals,
  .man-category,
  .woman-category {
      padding: 30px 0;
      background: none;
  }

  .product-card {
      position: relative;
      text-align: center;
      opacity: 0;
      animation: fadeIn 0.5s ease forwards;
  }

  @keyframes fadeIn {
      from {
          opacity: 0;
          transform: translateY(20px);
      }
      to {
          opacity: 1;
          transform: translateY(0);
      }
  }

  .pc__img-wrapper {
      position: relative;
      width: 100%;
      overflow: hidden;
  }

  .pc__img {
      width: 100%;
      height: auto;
      object-fit: cover;
      object-position: center;
      display: block;
      transition: opacity 0.3s ease;
  }

  .pc__img-hover {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: auto;
      object-fit: cover;
      object-position: center;
      opacity: 0;
      transition: opacity 0.3s ease;
  }

  .product-card:hover .pc__img {
      opacity: 0;
  }

  .product-card:hover .pc__img-hover {
      opacity: 1;
  }

  .pc__info {
      padding: 15px 0;
      text-align: center;
  }

  .pc__title {
      font-size: 1.2rem;
      font-weight: 600;
      color: #2d3436;
      margin-bottom: 8px;
      font-family: 'Lora', serif;
      text-transform: capitalize;
  }

  .pc__title a {
      color: #2d3436;
      text-decoration: none;
      transition: color 0.3s ease;
  }

  .pc__title a:hover {
      color: #ff6b6b;
  }

  .product-card__price {
      font-size: 1.1rem;
      font-weight: 600;
      color: #e91e63;
      font-family: 'Poppins', sans-serif;
  }

  .product-card__price s {
      color: #888;
      font-size: 0.9rem;
      margin-right: 8px;
      font-weight: 400;
  }

  .swiper-container {
      padding-bottom: 20px;
  }

  .swiper-slide {
      margin-bottom: 0;
  }

  .all-subcategories-section {
      padding: 60px 0;
      background: none;
  }

  .all-subcategories-section .section-title {
      font-size: 2rem;
      font-weight: 600;
      color: #2d3436;
      margin-bottom: 30px;
      position: relative;
      text-transform: uppercase;
      letter-spacing: 2px;
      font-family: 'Lora', serif;
      text-shadow: none;
  }

  .all-subcategories-section .section-title::after {
      content: '';
      width: 60px;
      height: 4px;
      background: linear-gradient(to right, #ff6b6b, #feca57);
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
  }

  .subcategory-card {
      display: block;
      text-decoration: none;
      border-radius: 15px;
      overflow: hidden;
      position: relative;
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      background: #fff;
      margin-bottom: 30px;
  }

  .subcategory-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
  }

  .subcategory-card-image {
      width: 100%;
      height: 400px;
      background-size: cover;
      background-position: top;
      position: relative;
      transition: transform 0.5s ease;
  }

  .subcategory-card:hover .subcategory-card-image {
      transform: scale(1.05);
  }

  .subcategory-card-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.6));
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 30px;
      transition: background 0.4s ease;
  }

  .subcategory-card:hover .subcategory-card-overlay {
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8));
  }

  .subcategory-card-title {
      font-size: 1.8rem;
      font-weight: 600;
      color: #fff;
      margin-bottom: 15px;
      text-transform: capitalize;
      letter-spacing: 1px;
      font-family: 'Lora', serif;
      line-height: 1.3;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
  }

  .subcategory-card-subtitle {
      font-size: 1.1rem;
      color: #f0f0f0;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      letter-spacing: 0.5px;
      font-weight: 300;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
  }

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
          padding-bottom: 15px;
      }

      .swiper-slide {
          height: auto;
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

      .summer-collection {
          display: block;
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
          height: 80px;
          margin: 0 auto 30px;
      }

      .summer-collection .image-gallery img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }
.summer-collection .text-content {
        display: block;
        max-width: 100%;
        padding: 0 20px;
        text-align: center;
        margin-top: 360px;
    }

      .summer-collection .text-content h3 {
          font-size: 12px;
      }

      .summer-collection .text-content h1 {
          font-size: 24px;
          margin-bottom: 10px;
      }

      .summer-collection .text-content p {
          font-size: 14px;
          margin-bottom: 5px;
      }

      .summer-collection .text-content button {
          padding: 8px 16px;
          font-size: 12px;
      }

      .new-arrivals,
      .man-category,
      .woman-category {
          padding: 20px 0;
      }

      .new-arrivals .section-title,
      .man-category .section-title,
      .woman-category .section-title {
          font-size: 1.5rem;
          margin-bottom: 20px;
      }

      .new-arrivals .section-title::after,
      .man-category .section-title::after,
      .woman-category .section-title::after {
          width: 40px;
          height: 3px;
          bottom: -8px;
      }

      .new-arrivals .section-title a,
      .man-category .section-title a,
      .woman-category .section-title a {
          font-size: 0.7rem;
      }

      .product-card {
          max-width: 340px;
          margin: 0 auto;
      }

      .sold-out-badge {
          bottom: 15px;
          right: 15px;
          font-size: 0.8rem;
          padding: 5px 10px;
      }

      .discount-badge {
          top: 8px;
          left: 8px;
          font-size: 0.8rem;
          padding: 3px 6px;
      }

      .pc__info {
          padding: 10px 0;
      }

      .pc__title {
          font-size: 1rem;
          margin-bottom: 6px;
      }

      .product-card__price {
          font-size: 0.9rem;
      }

      .product-card__price s {
          font-size: 0.8rem;
      }

      .all-subcategories-section {
          padding: 40px 0;
      }

      .all-subcategories-section .section-title {
          font-size: 1.5rem;
          margin-bottom: 20px;
      }

      .all-subcategories-section .section-title::after {
          width: 40px;
          height: 3px;
      }

      .subcategory-card {
          margin: 0 auto;
          max-width: 340px;
      }

      .subcategory-card-image {
          height: 350px;
          background-position: top;
      }

      .subcategory-card-title {
          font-size: 1.6rem;
          margin-bottom: 10px;
      }

      .subcategory-card-subtitle {
          font-size: 1rem;
      }

      .subcategory-card-overlay {
          padding: 20px;
      }
  }

  @media (max-width: 576px) {
      .all-subcategories-section {
          padding: 30px 0;
      }

      .all-subcategories-section .section-title {
          font-size: 1.3rem;
          margin-bottom: 15px;
      }

      .all-subcategories-section .section-title::after {
          width: 30px;
          height: 2px;
      }

      .subcategory-card {
          width: 100%;
          max-width: 300px;
          margin: 0 auto 20px auto;
          border-radius: 12px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
      }

      .subcategory-card-image {
          height: 300px;
          background-position: top;
      }

      .subcategory-card-title {
          font-size: 1.4rem;
          line-height: 1.3;
          margin-bottom: 8px;
      }

      .subcategory-card-subtitle {
          font-size: 0.9rem;
      }

      .subcategory-card-overlay {
          padding: 15px;
      }

      .new-arrivals .section-title,
      .man-category .section-title,
      .woman-category .section-title {
          font-size: 1.3rem;
          margin-bottom: 15px;
      }

      .new-arrivals .section-title::after,
      .man-category .section-title::after,
      .woman-category .section-title::after {
          width: 30px;
          height: 2px;
      }

      .sold-out-badge {
          bottom: 10px;
          right: 10px;
          font-size: 0.7rem;
          padding: 4px 8px;
      }

      .discount-badge {
          top: 6px;
          left: 6px;
          font-size: 0.7rem;
          padding: 2px 5px;
      }

      .pc__info {
          padding: 8px 0;
      }

      .pc__title {
          font-size: 0.9rem;
          margin-bottom: 5px;
      }

      .product-card__price {
          font-size: 0.8rem;
      }

      .product-card__price s {
          font-size: 0.7rem;
      }
  }

  @media (hover: none) {
      .subcategory-card:hover {
          transform: none;
          box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      }

      .subcategory-card:hover .subcategory-card-image {
          transform: none;
      }

      .subcategory-card:hover .subcategory-card-overlay {
          background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.6));
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
</style>

<main>
  <!-- Banner Slider Section -->
  <div class="trakkiez-main-banner-section">
      <div class="trakkiez-banner-wrapper">
          <div class="banner-slider">
              @foreach($slides as $index => $slide)
                  <div class="banner-slide {{ $index === 0 ? 'active' : '' }}">
                      <img loading="lazy" src="{{ asset('uploads/slides/' . $slide->image) }}" alt="Banner {{ $index + 1 }}" class="trakkiez-banner-image">
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

  <!-- Summer Collection -->
  <section class="summer-collection container mt-5">
      <div class="image-gallery">
          <div class="img1">
              <img loading="lazy" src="{{ asset('assets/images/main/h.avif') }}" alt="Summer 1">
          </div>
          <div class="img2">
              <img loading="lazy" src="{{ asset('assets/images/main/g.avif') }}" alt="Summer 2">
          </div>
          <div class="img3">
              <img loading="lazy" src="{{ asset('assets/images/main/b.avif') }}" alt="Summer 3">
          </div>
          <div class="img4">
              <img loading="lazy" src="{{ asset('assets/images/main/c.avif') }}" alt="Summer 4">
          </div>
          <div class="img5">
              <img loading="lazy" src="{{ asset('assets/images/main/a.avif') }}" alt="Summer 5">
          </div>
      </div>
      <div class="text-content">
          <h3>ALL NEW SUMMER COLLECTION</h3>
          <h1>Upto 20% OFF</h1>
          <p>Hurry up! Don’t miss the opportunity to get amazing designs and premium quality stuff for this latest summer collection.</p>
          <button onclick="window.location.href='{{ route('shop.index', ['filter' => 'summer-collection']) }}'">NEW SUMMER COLLECTION</button>
      </div>
  </section>

  
  <section class="new-arrivals container mt-3">
      <div class="text-center mb-3">
          <h2 class="section-title">New Arrivals <a href="{{ route('shop.index', ['filter' => 'new-arrivals']) }}">(View All)</a></h2>
      </div>
      <div class="row">
          <div class="col-12">
              <div class="position-relative">
                  <div class="swiper-container js-swiper-slider" data-settings='{
                      "autoplay": { "delay": 1500 },
                      "slidesPerView": 3,
                      "slidesPerGroup": 1,
                      "effect": "none",
                      "loop": false,
                      "breakpoints": {
                          "320": { "slidesPerView": 1, "slidesPerGroup": 1, "spaceBetween": 8 },
                          "768": { "slidesPerView": 2, "slidesPerGroup": 1, "spaceBetween": 15 },
                          "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 25 }
                      }
                  }'>
                      <div class="swiper-wrapper">
                          @foreach($newArrivals as $product)
                              <div class="swiper-slide product-card">
                                  <div class="pc__img-wrapper">
                                      <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                          <img loading="lazy" src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}" class="pc__img">
                                          @if($product->hover_image && $product->hover_image !== 'default-hover.jpg')
                                              <img loading="lazy" src="{{ asset('uploads/products/' . $product->hover_image) }}" alt="{{ $product->name }} Hover" class="pc__img-hover">
                                          @endif
                                      </a>
                                      @if($product->sale_price && $product->regular_price)
                                          @php
                                              $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                                          @endphp
                                          <div class="discount-badge">SAVE {{ $discount }}%</div>
                                      @endif
                                      @if($product->quantity <= 0)
                                          <div class="sold-out-badge">Sold Out</div>
                                      @endif
                                  </div>
                                  <div class="pc__info">
                                      <h6 class="pc__title">
                                          <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                              {{ $product->name }}
                                          </a>
                                      </h6>
                                      <div class="product-card__price">
                                          @if($product->sale_price)
                                              <s>PKR {{ $product->regular_price }}</s> PKR {{ $product->sale_price }}
                                          @else
                                              PKR {{ $product->regular_price }}
                                          @endif
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

 
  <section class="man-category container mt-3">
      <div class="text-center mb-3">
          <h2 class="section-title">Men's Collection <a href="{{ route('home.category', ['category_slug' => 'men']) }}">(View All)</a></h2>
      </div>
      <div class="row">
          <div class="col-12">
              <div class="position-relative">
                  <div class="swiper-container js-swiper-slider" data-settings='{
                      "autoplay": { "delay": 1500 },
                      "slidesPerView": 3,
                      "slidesPerGroup": 1,
                      "effect": "none",
                      "loop": false,
                      "breakpoints": {
                          "320": { "slidesPerView": 1, "slidesPerGroup": 1, "spaceBetween": 8 },
                          "768": { "slidesPerView": 2, "slidesPerGroup": 1, "spaceBetween": 15 },
                          "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 25 }
                      }
                  }'>
                      <div class="swiper-wrapper">
                          @if($manCategory && $manCategory->products->isNotEmpty())
                              @foreach($manCategory->products as $product)
                                  <div class="swiper-slide product-card">
                                      <div class="pc__img-wrapper">
                                          <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                              <img loading="lazy" src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}" class="pc__img">
                                              @if($product->hover_image && $product->hover_image !== 'default-hover.jpg')
                                                  <img loading="lazy" src="{{ asset('uploads/products/' . $product->hover_image) }}" alt="{{ $product->name }} Hover" class="pc__img-hover">
                                              @endif
                                          </a>
                                          @if($product->sale_price && $product->regular_price)
                                              @php
                                                  $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                                              @endphp
                                              <div class="discount-badge">SAVE {{ $discount }}%</div>
                                          @endif
                                          @if($product->quantity <= 0)
                                              <div class="sold-out-badge">Sold Out</div>
                                          @endif
                                      </div>
                                      <div class="pc__info">
                                          <h6 class="pc__title">
                                              <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                  {{ $product->name }}
                                              </a>
                                          </h6>
                                          <div class="product-card__price">
                                              @if($product->sale_price)
                                                  <s>PKR {{ $product->regular_price }}</s> PKR {{ $product->sale_price }}
                                              @else
                                                  PKR {{ $product->regular_price }}
                                              @endif
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

 
  <section class="woman-category container mt-3">
      <div class="text-center mb-3">
          <h2 class="section-title">Women's Collection <a href="{{ route('home.category', ['category_slug' => 'women']) }}">(View All)</a></h2>
      </div>
      <div class="row">
          <div class="col-12">
              <div class="position-relative">
                  <div class="swiper-container js-swiper-slider" data-settings='{
                      "autoplay": { "delay": 1500 },
                      "slidesPerView": 3,
                      "slidesPerGroup": 1,
                      "effect": "none",
                      "loop": false,
                      "breakpoints": {
                          "320": { "slidesPerView": 1, "slidesPerGroup": 1, "spaceBetween": 8 },
                          "768": { "slidesPerView": 2, "slidesPerGroup": 1, "spaceBetween": 15 },
                          "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 25 }
                      }
                  }'>
                      <div class="swiper-wrapper">
                          @if($womenCategory && $womenCategory->products->isNotEmpty())
                              @foreach($womenCategory->products as $product)
                                  <div class="swiper-slide product-card">
                                      <div class="pc__img-wrapper">
                                          <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                              <img loading="lazy" src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}" class="pc__img">
                                              @if($product->hover_image && $product->hover_image !== 'default-hover.jpg')
                                                  <img loading="lazy" src="{{ asset('uploads/products/' . $product->hover_image) }}" alt="{{ $product->name }} Hover" class="pc__img-hover">
                                              @endif
                                          </a>
                                          @if($product->sale_price && $product->regular_price)
                                              @php
                                                  $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                                              @endphp
                                              <div class="discount-badge">SAVE {{ $discount }}%</div>
                                          @endif
                                          @if($product->quantity <= 0)
                                              <div class="sold-out-badge">Sold Out</div>
                                          @endif
                                      </div>
                                      <div class="pc__info">
                                          <h6 class="pc__title">
                                              <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                  {{ $product->name }}
                                              </a>
                                          </h6>
                                          <div class="product-card__price">
                                              @if($product->sale_price)
                                                  <s>PKR {{ $product->regular_price }}</s> PKR {{ $product->sale_price }}
                                              @else
                                                  PKR {{ $product->regular_price }}
                                              @endif
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

 
  <section class="all-subcategories-section container mt-5">
      <div class="text-center mb-4">
          <h2 class="section-title">All Subcategories</h2>
      </div>
      <div class="row">
          @if($allSubcategories->isNotEmpty())
              @foreach($allSubcategories as $subcategory)
                  @if($subcategory && $subcategory->id && $subcategory->category && $subcategory->category->slug)
                      @php
                          $categorySlug = strtolower($subcategory->category->slug ?? 'unknown-category');
                          $subcategoryName = strtolower(str_replace(' ', '-', $subcategory->name ?? 'unnamed-subcategory'));
                          $imageName = "{$categorySlug}-{$subcategoryName}.jpg";
                          $imagePath = asset('assets/images/subcategories/' . $imageName);
                          $finalImage = file_exists(base_path('assets/images/subcategories/' . $imageName)) ? $imagePath : asset('assets/images/subcategories/default-subcategory.jpg');
                      @endphp
                      <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                          <a href="{{ route('home.subcategory', ['category_slug' => $subcategory->category->slug, 'subcategory_id' => $subcategory->id]) }}" class="subcategory-card">
                              <div class="subcategory-card-image" style="background-image: url('{{ $finalImage }}');">
                                  <div class="subcategory-card-overlay">
                                      <h2 class="subcategory-card-title">
                                          {{ $subcategory->category->name ?? 'Unknown Category' }} {{ $subcategory->name ?? 'Unnamed Subcategory' }}
                                      </h2>
                                      <p class="subcategory-card-subtitle">
                                          Explore {{ $subcategory->category->name ?? 'Unknown Category' }} {{ $subcategory->name ?? 'Unnamed Subcategory' }}
                                      </p>
                                  </div>
                              </div>
                          </a>
                      </div>
                  @else
                      <div class="col-12">
                          <p class="text-center text-muted">Invalid subcategory data.</p>
                      </div>
                  @endif
              @endforeach
          @else
              <div class="col-12">
                  <p class="text-center text-muted">Koi subcategories nahi hain.</p>
              </div>
          @endif
      </div>
  </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Banner Slider functionality
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

            setInterval(nextSlide, 5000); // Change slide every 5 seconds

            // Hover image effect for product cards
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(card => {
                const mainImg = card.querySelector('.pc__img');
                const hoverImg = card.querySelector('.pc__img-hover');

                if (hoverImg) { // Only add event listeners if hover image exists
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

        // Initialize Swiper
        document.addEventListener('DOMContentLoaded', function () {
        // Initialize Swiper for each slider
        document.querySelectorAll('.js-swiper-slider').forEach(function (slider) {
            // Get settings from the data-settings attribute
            let settings = JSON.parse(slider.getAttribute('data-settings'));

            // Initialize Swiper with the settings
            new Swiper(slider, settings);
        });
    });
    </script>
@endsection
