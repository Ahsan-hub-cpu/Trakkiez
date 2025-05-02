@extends("layouts.app")
@section("content")
<main>
  <div class="trakkiez-main-banner-section">
      <div class="trakkiez-banner-wrapper">
          <div class="banner-slider">
              @foreach($slides as $index => $slide)
                  <div class="banner-slide {{ $index === 0 ? 'active' : '' }}">
                      <img rel="preload" src="{{ asset('uploads/slides/' . $slide->image) }}" alt="Banner {{ $index + 1 }}" class="trakkiez-banner-image">
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
        <picture class="img1">
            <source srcset="assets/images/main/h.avif" type="image/avif">
            <img src="assets/images/main/h.avif" alt="Summer 1" loading="lazy" width="300" height="400">
        </picture>
        <picture class="img2">
            <source srcset="assets/images/main/g.avif" type="image/avif">
            <img src="assets/images/main/g.avif" alt="Summer 2" loading="lazy" width="300" height="400">
        </picture>
        <picture class="img3">
            <source srcset="assets/images/main/b.avif" type="image/avif">
            <img src="assets/images/main/b.avif" alt="Summer 3" loading="lazy" width="300" height="400">
        </picture>
        <picture class="img4">
            <source srcset="assets/images/main/c.avif" type="image/avif">
            <img src="assets/images/main/c.avif" alt="Summer 4" loading="lazy" width="300" height="400">
        </picture>
        <picture class="img5">
            <source srcset="assets/images/main/a.avif" type="image/avif">
            <img src="assets/images/main/a.avif" alt="Summer 5" loading="lazy" width="300" height="400">
        </picture>
    </div>
    <div class="text-content">
        <h3>ALL NEW SUMMER COLLECTION</h3>
        <h1>Upto 20% OFF</h1>
        <p>Hurry up! Don’t miss the opportunity to get amazing designs and premium quality stuff for this latest summer collection.</p>
        <a href="{{ route('shop.index', ['filter' => 'summer-collection']) }}" class="btn">NEW SUMMER COLLECTION</a>
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
        "autoplay": false,
        "slidesPerView": 2,
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
            "320": { "slidesPerView": 1, "slidesPerGroup": 1, "spaceBetween": 8 },
            "576": { "slidesPerView": 2, "slidesPerGroup": 1, "spaceBetween": 8 },
            "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 25 }
        },
        "watchSlidesVisibility": true,
        "watchSlidesProgress": true
    }'>
        <div class="swiper-wrapper">
            @foreach($newArrivals as $product)
                <div class="swiper-slide product-card">
                    <div class="pc__img-wrapper">
                        <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                            <img class="swiper-lazy pc__img" 
                                data-src="{{ asset('uploads/products/' . $product->image) }}" 
                                alt="{{ $product->name }}">
                            @if($product->hover_image && $product->hover_image !== 'default-hover.jpg')
                                <img class="swiper-lazy pc__img-hover" 
                                    data-src="{{ asset('uploads/products/' . $product->hover_image) }}" 
                                    alt="{{ $product->name }} Hover">
                            @endif
                            <div class="swiper-lazy-preloader"></div>
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
        "autoplay": false,
        "slidesPerView": 2,
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
            "320": { "slidesPerView": 1, "slidesPerGroup": 1, "spaceBetween": 8 },
            "576": { "slidesPerView": 2, "slidesPerGroup": 1, "spaceBetween": 8 },
            "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 25 }
        },
        "watchSlidesVisibility": true,
        "watchSlidesProgress": true
    }'>
        <div class="swiper-wrapper">
            @if($manCategory && $manCategory->products->isNotEmpty())
                @foreach($manCategory->products as $product)
                <div class="swiper-slide product-card">
                    <div class="pc__img-wrapper">
                        <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                            <img class="swiper-lazy pc__img" 
                                data-src="{{ asset('uploads/products/' . $product->image) }}" 
                                alt="{{ $product->name }}">
                            @if($product->hover_image && $product->hover_image !== 'default-hover.jpg')
                                <img class="swiper-lazy pc__img-hover" 
                                    data-src="{{ asset('uploads/products/' . $product->hover_image) }}" 
                                    alt="{{ $product->name }} Hover">
                            @endif
                            <div class="swiper-lazy-preloader"></div>
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
        "autoplay": false,
        "slidesPerView": 2,
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
            "320": { "slidesPerView": 1, "slidesPerGroup": 1, "spaceBetween": 8 },
            "576": { "slidesPerView": 2, "slidesPerGroup": 1, "spaceBetween": 8 },
            "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 12 }
        },
        "watchSlidesVisibility": true,
        "watchSlidesProgress": true
    }'>
        <div class="swiper-wrapper">
            @if($womenCategory && $womenCategory->products->isNotEmpty())
                @foreach($womenCategory->products as $product)
                <div class="swiper-slide product-card">
                    <div class="pc__img-wrapper">
                        <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                            <img class="swiper-lazy pc__img" 
                                data-src="{{ asset('uploads/products/' . $product->image) }}" 
                                alt="{{ $product->name }}">
                            @if($product->hover_image && $product->hover_image !== 'default-hover.jpg')
                                <img class="swiper-lazy pc__img-hover" 
                                    data-src="{{ asset('uploads/products/' . $product->hover_image) }}" 
                                    alt="{{ $product->name }} Hover">
                            @endif
                            <div class="swiper-lazy-preloader"></div>
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
          <h2 class="section-title">Featured</h2>
      </div>
      <div class="row">
    @if($allSubcategories->isNotEmpty())
        @foreach($allSubcategories as $subcategory)
            @if($subcategory && $subcategory->id && $subcategory->category && $subcategory->category->slug)
                @php
                    $categorySlug = strtolower($subcategory->category->slug ?? 'unknown-category');
                    $subcategoryName = strtolower(str_replace(' ', '-', $subcategory->name ?? 'unnamed-subcategory'));
                    $imageName = "{$categorySlug}-{$subcategoryName}.avif";
                    $imagePath = asset('assets/images/subcategories/' . $imageName);
                    $finalImage = file_exists(base_path('assets/images/subcategories/' . $imageName)) ? $imagePath : asset('assets/images/subcategories/default-subcategory.jpg');
                @endphp
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <a href="{{ route('home.subcategory', ['category_slug' => $subcategory->category->slug, 'subcategory_id' => $subcategory->id]) }}" class="subcategory-card">
                        <div class="subcategory-card-image lazy-background" data-bg="{{ $finalImage }}">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
    </script>
@endsection

