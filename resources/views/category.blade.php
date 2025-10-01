@extends('layouts.app')

@section('content')
<style>
  /* Category Page Color Scheme */
  .category-header {
      background: var(--bg-gradient-dark);
      color: white;
      padding: 60px 0;
      text-align: center;
      position: relative;
      overflow: hidden;
  }

  .category-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="categoryGrid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="%23ff6b6b" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23categoryGrid)"/></svg>');
      opacity: 0.1;
      z-index: 1;
  }

  .category-title {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 1rem;
      position: relative;
      z-index: 2;
      text-transform: uppercase;
  }

  .category-subtitle {
      font-size: 1.2rem;
      opacity: 0.9;
      position: relative;
      z-index: 2;
  }

  .section-title {
      font-size: 2rem;
      font-weight: 700;
      text-transform: uppercase;
      color: var(--text-primary);
      margin-bottom: 2rem;
      text-align: center;
  }

  .product-card {
      margin-bottom: 2rem;
  }

  .pc__img-wrapper {
    position: relative;
    overflow: hidden;
  }

  .pc__img {
      width: 100%;
      height: auto;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: opacity 0.3s ease;
  }

  .pc__img-primary {
    opacity: 1;
  }

  /* .pc__img-hover {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
  } */

  /* .product-card:hover .pc__img-primary,
  .product-card.active .pc__img-primary {
    opacity: 0;
  }

  .product-card:hover .pc__img-hover,
  .product-card.active .pc__img-hover {
    opacity: 1;
  } */

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

  .pagination {
      justify-content: center;
      margin-top: 2rem;
  }

  .filter-section {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 30px;
  }

  .filter-section .form-select,
  .filter-section .form-control {
      border-radius: 8px;
      border: 1px solid #e0e0e0;
      padding: 10px;
      font-size: 14px;
      transition: all 0.3s ease;
  }

  .filter-section .form-select:hover,
  .filter-section .form-control:hover {
      border-color: #ff6f61;
  }

  .filter-section .form-select:focus,
  .filter-section .form-control:focus {
      border-color: #ff6f61;
      box-shadow: 0 0 0 2px rgba(255, 111, 97, 0.2);
  }

  .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 30px;
  }

  /*.price-input-group {*/
  /*    display: flex;*/
  /*    gap: 10px;*/
  /*}*/

  /*.price-input-group .form-control {*/
  /*    flex: 1;*/
  /*}*/

  @media (max-width:768px){
    .section-title {
      font-size: 2rem;
      font-weight: 700;
      text-transform: uppercase;
      color: #333;
      margin-bottom: 2rem;
      margin-top: -5rem;
      text-align: center;
    }
    .pc__img {
      width: 100%;
      height: auto;
    }
  }

  @media (max-width: 576px) {
    .filter-section .row > div {
      margin-bottom: 15px;
      width: 100%;
    }
    .filter-section .form-select,
    .filter-section .form-control {
      font-size: 12px;
      padding: 8px;
    }
    /*.price-input-group {*/
    /*  flex-direction: column;*/
    /*  gap: 5px;*/
    /*}*/
    .pc__img {
      width: 100%;
      height: auto;
    }
  }
</style>

<main class="container mt-5">
  <h2 class="section-title">{{ $category->name }} Products</h2>

  <!-- Filter Section -->
  <div class="container mb-4">
    <div class="filter-section">
      <div class="row">
        <!-- Brand Filter -->
        <div class="col-md-3 col-sm-6 mb-3">
          <select id="brand-filter" class="form-select">
            <option value="">Filter by Brand</option>
            @if(isset($brands) && $brands->count() > 0)
              @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
              @endforeach
            @endif
          </select>
        </div>
        <!-- Price Filter -->
        <!-- <div class="col-md-3">-->
        <!--<button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#priceFilterModal">-->
        <!--    Filter by Price-->
        <!--</button>-->
        <!--</div>-->
        <!-- Sort Filter -->
        <div class="col-md-3 col-sm-6 mb-3">
          <select id="sort-by" class="form-select">
            <option value="">Sort By</option>
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest to Oldest</option>
            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest to Newest</option>
            <option value="a-z" {{ request('sort') == 'a-z' ? 'selected' : '' }}>Alphabetically A to Z</option>
            <option value="z-a" {{ request('sort') == 'z-a' ? 'selected' : '' }}>Alphabetically Z to A</option>
            <option value="price-low-high" {{ request('sort') == 'price-low-high' ? 'selected' : '' }}>Price Low to High</option>
            <option value="price-high-low" {{ request('sort') == 'price-high-low' ? 'selected' : '' }}>Price High to Low</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- Clear Filter Button -->
  @if(request()->has('size') || request()->has('sort') || request()->has('brand'))
    <div class="text-center mt-3">
      <a href="{{ route('home.category', $category->slug) }}" class="btn btn-outline-dark">Clear Filter</a>
    </div>
  @endif

  <!-- Product Count -->
  <div class="container mb-3">
    <div class="row">
      <div class="col">
        <p class="lead">
          @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $products->total() }} products
          @else
            {{ count($products) }} products
          @endif
        </p>
      </div>
    </div>
  </div>

  <!-- Product Grid -->
  @if($products->isNotEmpty())
    <div class="row">
      @foreach($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="product-card product-card_style3" style="position: relative;">
            <div class="pc__img-wrapper">
           <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}" 
   class="product-link" 
   data-product-id="{{ $product->id }}"
   data-product-name="{{ $product->name }}"
   data-product-price="{{ $product->sale_price ?? $product->regular_price }}"
   data-product-category="{{ $category->name ?? 'unknown category' }}"
$GLOBALS["__SELF__"]->wrapFunction(array(null,'aria-label'))="View details for {{ $product->name }}">
    <img loading="lazy" src="{{ asset('uploads/products/' . $product->main_image) }}" 
         width="200" height="auto" alt="{{ $product->name }}" 
         class="pc__img pc__img-primary">
</a>
              @if($product->stock_status === 'out_of_stock')
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
        </div>
      @endforeach
    </div>

   
    <!-- Pagination -->
    @if(!request()->has('size') && !request()->has('sort') && !request()->has('subcategory') && !request()->has('brand'))
      <div class="divider"></div>
      <div class="flex items-center justify-between flex-wrap gap10 wgp pagination">
        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
      </div>
    @endif
  @else
    <p>No products available in this category.</p>
  @endif
</main>
<script defer src="{{ asset('assets/js/facebook-pixel.js') }}"></script>
@endsection

@push('scripts')
<script>
$(function(){
  console.log('Filter script initialized');

  // Brand filter
  $('#brand-filter').on('change', function() {
    console.log('Brand filter changed:', $(this).val());
    updateUrl('brand', $(this).val());
  });

  // Size filter
  $('#size-filter').on('change', function() {
    console.log('Size filter changed:', $(this).val());
    updateUrl('size', $(this).val());
  });

  // Sort filter
  $('#sort-by').on('change', function() {
    console.log('Sort filter changed:', $(this).val());
    updateUrl('sort', $(this).val());
  });

  // Mobile touch toggle for hover effect
  $('.product-card').on('click', function(e) {
    e.preventDefault();
    $(this).toggleClass('active');
    console.log('Product card toggled:', $(this).hasClass('active') ? 'Active' : 'Inactive');
  });

  // Ensure link navigation on second tap
  $('.product-card a').on('click', function(e) {
    if ($(this).closest('.product-card').hasClass('active')) {
      window.location.href = $(this).attr('href');
    }
  });

  // Price filter inputs
  /*
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
  */

  function updateUrl(key, value) {
    console.log('Updating URL with', key, value);
    var url = new URL(window.location.href);
    var searchParams = new URLSearchParams(url.search);
    if (value) {
      searchParams.set(key, value);
    } else {
      searchParams.delete(key);
    }
    url.search = searchParams.toString();
    console.log('Updated URL:', url.toString());
    window.location.href = url.toString();
  }
});
</script>
@endpush
