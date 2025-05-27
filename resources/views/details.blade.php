@extends('layouts.app')
@section('content')
<style>
  .filled-heart {
    color: orange;
  }

  .size-btn {
    min-width: 60px;
    position: relative;
    transition: all 0.3s ease;
    border-radius: 4px;
    padding: 8px 12px;
  }

  .size-btn.active {
    background:black;
    color: white;
    border-color:black;
  }

  .size-btn.sold-out {
    opacity: 0.6;
    cursor: not-allowed;
    position: relative;
  }

  .size-btn.sold-out::after {
    content: "______";
    position: absolute;
    top: 30%;
    left: 30%;
    transform: translate(-50%, -50%);
    font-size: 1.2em;
  }

  .sold-out-text {
    font-size: 0.7em;
    margin-left: 4px;
    color: #dc3545;
  }

  .sold-out-label {
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

  .pc__sold-out {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: #fff;
    padding: 5px 10px;
    font-weight: bold;
    border-radius: 3px;
    z-index: 10;
  }

  .qty-error {
    color: red;
    font-size: 0.8rem;
    margin-top: 4px;
  }

  .size-chart-btn {
    display: inline-block;
    margin-left: 10px;
    padding: 8px 16px;
    background-color: #000000;
    color: white;
    border: none;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 30%;
    height:4rem;
  }

  .size-chart-btn:hover {
    background-color: #333333;
  }

  .lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    z-index: 1000;
    justify-content: center;
    align-items: center;
  }

  .lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 80%;
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .lightbox-images {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    max-height: 60vh;
    overflow-y: auto;
  }

  .lightbox-image {
    max-width: 100%;
    max-height: 30vh;
    object-fit: contain;
    border-radius: 4px;
  }

  .close {
    position: absolute;
    top: -15px;
    right: -15px;
    color: #fff;
    font-size: 30px;
    font-weight: bold;
    cursor: pointer;
    background: #000;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .close:hover {
    color: #ccc;
  }

  /* Reviews Section Styles */
  .reviews-section { padding: 20px 0; border-top: 1px solid #ddd; margin-top: 20px; }
  .review-summary { display: flex; align-items: center; gap: 20px; margin-bottom: 20px; flex-wrap: wrap; }
  .average-rating { font-size: 2rem; font-weight: bold; }
  .star-rating .fa-star { color: #ccc; }
  .star-rating .fa-star.checked { color: #f39c12; }
  .rating-breakdown { flex: 1; }
  .rating-bar { background: #ddd; height: 5px; border-radius: 5px; overflow: hidden; margin: 5px 0; }
  .rating-bar-fill { background: #dc3545; height: 100%; }
  .write-review-btn { background:black; color: white; border: none; padding: 10px 20px; border-radius: 4px; }
  /* .write-review-btn:hover { background: #e68900; } */
  .review-item { border-bottom: 1px solid #ddd; padding: 15px 0; }
  .review-meta { display: flex; gap: 10px; align-items: center; margin-bottom: 10px; }
  .pagination { justify-content: center; margin-top: 20px; }
  .pagination .page-link { color: #ff9800; }
  .pagination .page-item.active .page-link { background-color: #ff9800; border-color: #ff9800; color: white; }

  /* Modal Styles */
  .review-modal .modal-content { border-radius: 8px; }
  .review-modal .modal-header { background: #ff9800; color: white; }
  .review-modal .modal-footer { border-top: none; }
  .star-rating-input { display: flex; gap: 5px; }
  .star-rating-input .fa-star { font-size: 1.5rem; cursor: pointer; }
  .star-rating-input .fa-star.checked { color: #f39c12; }
  .review-form .error-message { color: #dc3545; font-size: 0.8rem; margin-top: 5px; display: none; }
  #rating-error { color: #dc3545; }

  /* Buy It Now Button Styles */
  .btn-buynow {
    background-color:black; /* Match Add to Cart button color */
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 0.9rem;
    font-weight: 500;
    width: 17.5rem; /* Full width for consistency */
    margin-top: 10px; /* Space above button */
    height:4rem;
  }

  

  .btn-buynow.loading {
    opacity: 0.7;
    cursor: not-allowed;
  }

  /* Responsive Styles */
  @media (max-width: 768px) {
    .size-chart-btn, .btn-buynow, .btn-addtocart {
      padding: 6px 12px;
      font-size: 0.8rem;
      margin-bottom: 1rem;
    }
    .lightbox-content { max-width: 95%; max-height: 85%; padding: 15px; }
    .lightbox-images { flex-direction: column; align-items: center; max-height: 70vh; }
    .lightbox-image { max-height: 35vh; width: 100%; }
    .gap-2 { gap: 0.5rem !important; margin-bottom: 1rem; }
    .average-rating { font-size: 1.5rem; }
    .review-summary { flex-direction: column; align-items: flex-start; gap: 10px; }
    .write-review-btn { width: 100%; text-align: center; }
  }

  @media (max-width: 480px) {
    .size-chart-btn, .btn-buynow, .btn-addtocart {
      padding: 5px 10px;
      font-size: 0.75rem;
    }
    .lightbox-content { max-width: 98%; max-height: 90%; padding: 10px; }
    .lightbox-image { max-height: 30vh; }
    .review-meta { flex-direction: column; align-items: flex-start; }
    .star-rating-input .fa-star { font-size: 1.2rem; }
  }

  .text-success { color: black !important; }
  .gap-2 { gap: 0.5rem !important; margin-bottom: 1rem; margin-top: 1rem; }
  .btn-addtocart.loading { opacity: 0.7; cursor: not-allowed; }
</style>

<main class="pt-90">
  <div class="mb-md-1 pb-md-3"></div>
  <section class="product-single container">
    <div class="row">
      <div class="col-lg-7">
        <div class="product-single__media" data-media-type="vertical-thumbnail">
          <div class="product-single__image">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <div class="swiper-slide product-single__image-item">
                  <img loading="lazy" class="h-auto" src="{{ asset('uploads/products/' . $product->image) }}" width="674" height="674" alt="{{ $product->name }}" />
                  <a data-fancybox="gallery" href="{{ asset('uploads/products/' . $product->image) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_zoom" />
                    </svg>
                  </a>
                </div>
                @foreach(explode(',', $product->images) as $gimg)
                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{ asset('uploads/products/' . $gimg) }}" width="674" height="674" alt="{{ $product->name }}" />
                    <a data-fancybox="gallery" href="{{ asset('uploads/products/' . $gimg) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>
                @endforeach
              </div>
              <div class="swiper-button-prev">
                <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_prev_sm" />
                </svg>
              </div>
              <div class="swiper-button-next">
                <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_sm" />
                </svg>
              </div>
            </div>
          </div>
          <div class="product-single__thumbnail">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <div class="swiper-slide product-single__image-item">
                  <img loading="lazy" class="h-auto" src="{{ asset('uploads/products/thumbnails/' . $product->image) }}" width="104" height="104" alt="{{ $product->name }}" />
                </div>
                @foreach(explode(',', $product->images) as $gimg)
                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{ asset('uploads/products/' . $gimg) }}" width="104" height="104" alt="{{ $product->name }}" />
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="d-flex justify-content-between mb-4 pb-md-2">
          <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
          </div>
          <div class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
          </div>
        </div>
        <h1 class="product-single__name">{{ $product->name }}</h1>
        <div class="product-single__rating">
          <!-- Rating will be displayed in the reviews section below -->
        </div>
        <div class="product-single__price">
          <span class="current-price">
            @if($product->sale_price)
              <s>PKR {{ $product->regular_price }}</s> PKR {{ $product->sale_price }}
            @else
              PKR {{ $product->regular_price }}
            @endif
          </span>
        </div>
        <div class="product-single__short-desc">
          <p>{{ $product->short_description }}</p>
        </div>
        @if($product->quantity <= 0)
          <span class="btn btn-secondary mb-3">Sold Out</span>
        @else
          <form id="add-to-cart-form" method="POST" action="{{ route('cart.add') }}">
            @csrf
            <div class="product-single__options">
              <div class="d-flex align-items-center">
                <label>Size:</label>
                @if($product->size_chart)
                  <button type="button" class="size-chart-btn" onclick="openLightbox()">Size Chart</button>
                @endif
              </div>
  <div class="size-selector d-flex flex-wrap gap-2">
                @if($product->productVariations && $product->productVariations->count() > 0)
                  @php
                    // Define the desired order of sizes
                    $sizeOrder = ['Small', 'Medium', 'Large', 'XL', 'XXL'];
                    // Sort the product variations based on the size order
                    $sortedVariations = $product->productVariations->sortBy(function($variation) use ($sizeOrder) {
                      return array_search($variation->size->name, $sizeOrder);
                    });
                  @endphp
                  @foreach($sortedVariations as $variation)
                    <button type="button" 
                      class="size-btn btn btn-outline-secondary {{ $variation->quantity <= 0 ? 'sold-out' : '' }}"
                      data-size-id="{{ $variation->size->id }}"
                      data-quantity="{{ $variation->quantity }}"
                      {{ $variation->quantity <= 0 ? 'disabled' : '' }}>
                      {{ $variation->size->name }}
                      @if($variation->quantity <= 0)
                        <span class="sold-out-text">(Sold Out)</span>
                      @endif
                    </button>
                  @endforeach
                @else
                  <div class="text-muted">No sizes available</div>
                @endif
              </div>
              <input type="hidden" name="size_id" id="selected_size" value="">
            </div>

            <div class="product-single__addtocart d-flex flex-column align-items-start gap-2">
              <div class="qty-control position-relative">
                <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
                <div class="qty-control__reduce">-</div>
                <div class="qty-control__increase">+</div>
              </div>
              <div class="qty-error">
                @error('quantity')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <input type="hidden" name="id" value="{{ $product->id }}" />
              <input type="hidden" name="name" value="{{ $product->name }}" />
              <input type="hidden" name="price" value="{{ $product->sale_price ?: $product->regular_price }}" />
              <button type="submit" class="btn btn-primary btn-addtocart">Add to Cart</button>
              <button type="button" class="btn btn-buynow" onclick="buyNow()">Buy It Now</button>
              <span class="cart-status text-success ms-2" aria-live="polite"></span>
            </div>
          </form>
        @endif
        <div class="product-single__addtolinks">
          @if(Cart::instance("wishlist")->content()->where('id', $product->id)->count() > 0)
            <form method="POST" action="{{ route('wishlist.remove', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}" id="wishlist-remove-form">
              @csrf
              @method('DELETE')
              <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist filled-heart" onclick="document.getElementById('wishlist-remove-form').submit();">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_heart" />
                </svg>
                <span>Remove from Wishlist</span>
              </a>
            </form>
          @else
            <form method="POST" action="{{ route('wishlist.add') }}" id="wishlist-add-form">
              @csrf
              <input type="hidden" name="id" value="{{ $product->id }}" />
              <input type="hidden" name="name" value="{{ $product->name }}" />
              <input type="hidden" name="quantity" value="1"/>
              <input type="hidden" name="price" value="{{ $product->sale_price ?: $product->regular_price }}" />
              <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist" onclick="document.getElementById('wishlist-add-form').submit()">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_heart" />
                </svg>
                <span>Add to Wishlist</span>
              </a>
            </form>
          @endif
          <share-button class="share-button"></share-button>
          <div class="product-single__meta-info">
            <div class="meta-item">
              <label>SKU:</label>
              <span>{{ $product->SKU }}</span>
            </div>
            <div class="meta-item">
              <label>Categories:</label>
              <span>{{ $product->category->name }}</span>
            </div>
            <div class="meta-item">
              <label>Tags:</label>
              <span>N/A</span>
            </div>
          </div>
        </div>
        <div class="product-single__details-tab">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab" href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Description</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-description" role="tabpanel" aria-labelledby="tab-description-tab">
              <div class="product-single__description">
                {{ $product->description }}
              </div>
            </div>
          </div>

          <!-- Reviews Section -->
          <div class="reviews-section">
            <h2 class="h3 text-uppercase mb-4">Customer <strong>Reviews</strong></h2>
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            <div class="review-summary">
              <div class="rating-overview">
                <span class="average-rating">{{ number_format($averageRating, 1) }}</span>
                <div class="star-rating d-inline-block">
                  @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= round($averageRating) ? 'checked' : '' }}"></i>
                  @endfor
                </div>
                <p class="review-count">({{ $reviewCount }} reviews)</p>
              </div>
              <button class="write-review-btn" data-bs-toggle="modal" data-bs-target="#reviewModal">Write a Review</button>
            </div>
            <div class="reviews-list">
              @if($reviews->count() > 0)
                @foreach($reviews as $review)
                  <div class="review-item">
                    <div class="review-meta">
                      <div class="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                          <i class="fas fa-star {{ $i <= $review->rating ? 'checked' : '' }}"></i>
                        @endfor
                      </div>
                      <span class="reviewer-name">{{ $review->reviewer_name ?? 'Anonymous' }}</span>
                      <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    <p class="review-text">{{ $review->review }}</p>
                  </div>
                @endforeach
                <nav aria-label="Reviews pagination">
                  {{ $reviews->links('pagination::bootstrap-5') }}
                </nav>
              @else
                <p>No reviews yet. Be the first to write a review!</p>
              @endif
            </div>
          </div>
          <!-- End Reviews Section -->
        </div>
      </div>

      @if($product->size_chart)
        <div id="size-chart-lightbox" class="lightbox">
          <div class="lightbox-content">
            <span class="close" onclick="closeLightbox()">×</span>
            <div class="lightbox-images">
              @foreach(explode(',', $product->size_chart) as $chartImage)
                <img class="lightbox-image" src="{{ asset('uploads/products/' . $chartImage) }}" alt="Size Chart">
              @endforeach
            </div>
          </div>
        </div>
      @endif
  </section>
  <section class="products-carousel container">
    <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>
    <div id="related_products" class="position-relative">
      <div class="swiper-container js-swiper-slider" data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
        <div class="swiper-wrapper">
          @foreach($rproducts as $rproduct)
            <div class="swiper-slide product-card" style="position: relative;">
              <div class="pc__img-wrapper">
                <a href="{{ route('shop.product.details', ['product_slug' => $rproduct->slug]) }}">
                  <img loading="lazy" src="{{ asset('uploads/products/' . $rproduct->image) }}" width="330" height="400" alt="{{ $rproduct->name }}" class="pc__img">
                </a>
                @if($rproduct->quantity <= 0)
                  <div class="sold-out-label">Sold Out</div>
                @endif
              </div>
              <div class="pc__info position-relative">
                <p class="pc__category">{{ $rproduct->category->name }}</p>
                <h6 class="pc__title">
                  <a href="{{ route('shop.product.details', ['product_slug' => $rproduct->slug]) }}">{{ $rproduct->name }}</a>
                </h6>
                <div class="product-card__price d-flex">
                  <span class="money price">
                    @if($rproduct->sale_price)
                      <s>PKR {{ $rproduct->regular_price }}</s> PKR {{ $rproduct->sale_price }}
                    @else
                      PKR {{ $rproduct->regular_price }}
                    @endif
                  </span>
                </div>
                <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_heart" />
                  </svg>
                </button>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
          <use href="#icon_prev_md" />
        </svg>
      </div>
      <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
          <use href="#icon_next_md" />
        </svg>
      </div>
      <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
    </div>
  </section>

  <!-- Review Modal -->
  <div class="modal fade review-modal" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="review-form" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="mb-3">
              <label for="rating" class="form-label">Your Rating</label>
              <div class="star-rating-input" id="rating-input">
                @for ($i = 1; $i <= 5; $i++)
                  <i class="fas fa-star" data-value="{{ $i }}"></i>
                @endfor
              </div>
              <input type="hidden" name="rating" id="rating" value="0">
              <div class="error-message" id="rating-error"></div>
            </div>
            <div class="mb-3">
              <label for="reviewer_name" class="form-label">Your Name</label>
              <input type="text" class="form-control" id="reviewer_name" name="reviewer_name" maxlength="255">
            </div>
            <div class="mb-3">
              <label for="review" class="form-label">Your Review</label>
              <textarea class="form-control" id="review" name="review" rows="4" maxlength="1000" required></textarea>
              <div class="error-message" id="review-error"></div>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const $quantityInput = $('input.qty-control__number');
    const $qtyError = $('.qty-error');
    const $cartStatus = $('.cart-status');
    const $addToCartBtn = $('.btn-addtocart');
    const $buyNowBtn = $('.btn-buynow');
    let selectedSize = null;
    let cartItems = [];

    // Catalog ID mapping for products
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

    // Fetch initial cart items on page load
    $.ajax({
        url: '{{ route('cart.partial') }}',
        method: 'GET',
        success: function(response) {
            const $cartContent = $(response);
            cartItems = $cartContent.find('.cart-item').map(function() {
                return {
                    id: $(this).data('id'),
                    name: $(this).data('name'),
                    price: $(this).data('price'),
                    quantity: $(this).data('quantity')
                };
            }).get();

            if (cartItems.length > 0 && typeof fbq !== 'undefined') {
                const totalValue = cartItems.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
                fbq('track', 'AddToCart', {
                    content_ids: cartItems.map(item => catalogIdMapping[item.id] || item.id),
                    content_type: 'product',
                    value: totalValue,
                    currency: 'PKR',
                    contents: cartItems.map(item => ({
                        id: catalogIdMapping[item.id] || item.id,
                        quantity: item.quantity,
                        content_name: item.name
                    }))
                });
            }
        },
        error: function(xhr) {
            console.error('Failed to load initial cart:', xhr.responseText);
        }
    });

    $('.size-btn').on('click', function() {
        const $btn = $(this);
        if ($btn.hasClass('sold-out') || $btn.prop('disabled')) return;
        $('.size-btn').removeClass('active');
        $btn.addClass('active');
        selectedSize = {
            id: $btn.data('size-id'),
            quantity: $btn.data('quantity')
        };
        $('#selected_size').val(selectedSize.id);
        $quantityInput.attr('max', selectedSize.quantity);
        if (parseInt($quantityInput.val()) > selectedSize.quantity) {
            $quantityInput.val(1);
            $qtyError.text('');
        }
    });

    $('.qty-control__increase').on('click', function() {
        if (!selectedSize) {
            $qtyError.text('Please select a size first');
            return;
        }
        const currentVal = parseInt($quantityInput.val()) || 1;
        if (currentVal < selectedSize.quantity) {
            $quantityInput.val(currentVal);
            $qtyError.text('');
        } else {
            $qtyError.text(`Only ${selectedSize.quantity} items available`);
        }
    });

    $('.qty-control__reduce').on('click', function() {
        const currentVal = parseInt($quantityInput.val()) || 1;
        if (currentVal > 1) {
            $quantityInput.val(currentVal);
            $qtyError.text('');
        }
    });

    $quantityInput.on('input', function() {
        if (!selectedSize) {
            $qtyError.text('Please select a size first');
            $quantityInput.val(1);
            return;
        }
        const currentVal = parseInt($quantityInput.val());
        const maxVal = selectedSize.quantity;
        if (currentVal > maxVal) {
            $qtyError.text(`Only ${maxVal} items available`);
            $quantityInput.val(maxVal);
        } else if (currentVal < 1 || isNaN(currentVal)) {
            $quantityInput.val(1);
            $qtyError.text('');
        } else {
            $qtyError.text('');
        }
    });

    $('#add-to-cart-form').on('submit', function(e) {
        e.preventDefault();
        if (!selectedSize) {
            $qtyError.text('Please select a size');
            return;
        }
        const $form = $(this);
        $addToCartBtn.addClass('loading').prop('disabled', true).text('Adding...');
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                $addToCartBtn.removeClass('loading').prop('disabled', false).text('Add to Cart');
                if (response.success) {
                    $cartStatus.text('Added to cart').show().fadeOut(3000);
                    $qtyError.text('');
                    $quantityInput.val(1);
                    $('.size-btn').removeClass('active');
                    $('#selected_size').val('');
                    selectedSize = null;
                    $('.cart-count-overlay').text(response.count).attr('aria-label', `Cart contains ${response.count} items`);
                    $('#cart-modal-content').html(response.content);
                    $('#cartModal').modal('show');

                    cartItems = response.cartItems || cartItems;
                    if (cartItems.length > 0 && typeof fbq !== 'undefined') {
                        const productId = '{{ $product->id }}';
                        const catalogId = catalogIdMapping[productId] || productId;
                        const productName = '{{ addslashes($product->name) }}';
                        const productPrice = parseFloat('{{ $product->sale_price ?: $product->regular_price }}');
                        const quantity = parseInt($quantityInput.val()) || 1;

                        fbq('track', 'AddToCart', {
                            content_ids: [catalogId],
                            content_type: 'product',
                            value: productPrice * quantity,
                            currency: 'PKR',
                            contents: [{
                                id: catalogId,
                                quantity: quantity,
                                content_name: productName
                            }]
                        });
                    }
                } else {
                    $qtyError.text(response.message || 'Failed to add to cart');
                }
            },
            error: function(xhr) {
                console.error('Add to cart error:', xhr.responseJSON || xhr.responseText);
                $addToCartBtn.removeClass('loading').prop('disabled', false).text('Add to Cart');
                $qtyError.text(xhr.responseJSON?.message || 'An error occurred while adding to cart');
                $.ajax({
                    url: '{{ route('cart.partial') }}',
                    method: 'GET',
                    success: function(cartContent) {
                        $('#cart-modal-content').html(cartContent);
                        $('#cartModal').modal('show');
                    },
                    error: function(cartXhr) {
                        console.error('Cart content load error:', cartXhr.responseText);
                        $qtyError.text('Failed to load cart content');
                    }
                });
            }
        });
    });

    // Buy It Now handler
    window.buyNow = function() {
        if (!selectedSize) {
            $qtyError.text('Please select a size');
            return;
        }
        const $form = $('#add-to-cart-form');
        $buyNowBtn.addClass('loading').prop('disabled', true).text('Processing...');
        $.ajax({
            url: '{{ route('cart.add') }}',
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                $buyNowBtn.removeClass('loading').prop('disabled', false).text('Buy It Now');
                if (response.success) {
                    $qtyError.text('');
                    $quantityInput.val(1);
                    $('.size-btn').removeClass('active');
                    $('#selected_size').val('');
                    selectedSize = null;
                    window.location.href = '{{ route('cart.checkout') }}';
                } else {
                    $qtyError.text(response.message || 'Failed to add to cart');
                }
            },
            error: function(xhr) {
                console.error('Buy now error:', xhr.responseJSON || xhr.responseText);
                $buyNowBtn.removeClass('loading').prop('disabled', false).text('Buy It Now');
                $qtyError.text(xhr.responseJSON?.message || 'An error occurred while processing your request');
            }
        });
    };

    // Size chart lightbox handlers
    window.openLightbox = function() {
        const $lightbox = $('#size-chart-lightbox');
        if ($lightbox.length === 0) {
            console.error('Size chart lightbox not found in DOM');
            return;
        }
        $lightbox.css('display', 'flex');
        document.body.style.overflow = 'hidden';
    };

    window.closeLightbox = function() {
        const $lightbox = $('#size-chart-lightbox');
        if ($lightbox.length === 0) {
            console.error('Size chart lightbox not found in DOM');
            return;
        }
        $lightbox.css('display', 'none');
        document.body.style.overflow = 'auto';
    };

    $(document).on('click', '#size-chart-lightbox', function(event) {
        if ($(event.target).is('#size-chart-lightbox')) {
            closeLightbox();
        }
    });

    // Review submission via AJAX
    $('#review-form').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const $ratingError = $('#rating-error');
        const $reviewError = $('#review-error');
        $ratingError.hide();
        $reviewError.hide();
        $submitBtn.prop('disabled', true).text('Submitting...');

        const rating = parseInt($('#rating').val());
        const reviewText = $('#review').val().trim();

        // Client-side validation
        let hasError = false;
        if (rating === 0) {
            $ratingError.text('Please select a rating').show();
            hasError = true;
        }
        if (!reviewText) {
            $reviewError.text('Please write your review').show();
            hasError = true;
        }
        if (hasError) {
            $submitBtn.prop('disabled', false).text('Submit Review');
            return;
        }

        $.ajax({
            url: '{{ route('reviews.store', $product->id) }}',
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                $submitBtn.prop('disabled', false).text('Submit Review');
                if (response.success) {
                    $('#reviewModal').modal('hide');
                    $form[0].reset();
                    $('#rating-input .fa-star').removeClass('checked');
                    $('#rating').val(0);
                    const $alert = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        'Review submitted successfully' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('.reviews-section').prepend($alert);
                } else {
                    $reviewError.text(response.message || 'Failed to submit review').show();
                }
            },
            error: function(xhr) {
                $submitBtn.prop('disabled', false).text('Submit Review');
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while submitting your review';
                $reviewError.text(errorMessage).show();
            }
        });
    });

    // Star rating input handler
    $('#rating-input .fa-star').on('click', function() {
        const value = $(this).data('value');
        $('#rating-input .fa-star').removeClass('checked');
        $('#rating-input .fa-star').each(function() {
            if ($(this).data('value') <= value) {
                $(this).addClass('checked');
            }
        });
        $('#rating').val(value);
        $('#rating-error').hide();
    });

    // Handle pagination via AJAX
    $(document).on('click', 'nav.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                $('.reviews-list').html(data);
                // Re-bind the event handler to new pagination links
                $(document).off('click', 'nav.pagination a').on('click', 'nav.pagination a', function(e) {
                    e.preventDefault();
                    const newUrl = $(this).attr('href');
                    $.ajax({
                        url: newUrl,
                        method: 'GET',
                        dataType: 'html',
                        success: function(newData) {
                            $('.reviews-list').html(newData);
                        },
                        error: function(xhr) {
                            console.error('Pagination error:', xhr.responseText);
                        }
                    });
                });
                history.pushState({}, '', url);
            },
            error: function(xhr) {
                console.error('Pagination error:', xhr.responseText);
            }
        });
    });
});
</script>
@endpush