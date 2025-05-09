@extends('layouts.app')

@section('content')
<style>
  .section-title {
      font-size: 2rem;
      font-weight: 700;
      text-transform: uppercase;
      color: #333;
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
  } */

  /* .product-card:hover .pc__img-hover,
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

  .price-input-group {
      display: flex;
      gap: 10px;
  }

  .price-input-group .form-control {
      flex: 1;
  }

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
    .price-input-group {
      flex-direction: column;
      gap: 5px;
    }
    .pc__img {
      width: 100%;
      height: auto;
    }
  }
</style>

<main class="container mt-5">
  <h2 class="section-title">{{ $subcategory->name }} Products</h2>

  <!-- Filter Section -->
  <div class="container mb-4">
    <div class="filter-section">
      <div class="row">
        <!-- Size Filter -->
        <div class="col-md-3 col-sm-6 mb-3">
          <select id="size-filter" class="form-select">
            <option value="">Filter by Size</option>
            @foreach($sizes as $size)
              <option value="{{ $size->id }}" {{ request('size') == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
            @endforeach
          </select>
        </div>
        <!-- Price Filter -->
        <!--
        <div class="col-md-3 col-sm-6 mb-3">
          <div class="price-input-group">
            <input type="number" id="price-from" class="form-control" placeholder="Min Price" value="{{ request('price_from') }}" min="0">
            <input type="number" id="price-to" class="form-control" placeholder="Max Price" value="{{ request('price_to') }}" min="0">
          </div>
          <small class="text-muted d-block mt-1">Highest price: PKR {{ $maxPrice }}</small>
        </div>
        -->
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
  @if(request()->has('size') || request()->has('sort'))
    <div class="text-center mt-3">
      <a href="{{ route('home.subcategory', ['category_slug' => $category->slug, 'subcategory_id' => $subcategory->id]) }}" class="btn btn-outline-dark">Clear Filter</a>
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
              <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}" aria-label="View details for {{ $product->name }}">
                <img loading="lazy" src="{{ asset('uploads/products/' . $product->image) }}" width="200" height="auto" alt="{{ $product->name }}" class="pc__img pc__img-primary">
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
        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    @if(!request()->has('size') && !request()->has('price_from') && !request()->has('price_to') && !request()->has('sort'))
      <div class="pagination">
        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
      </div>
    @endif
  @else
    <p>{{ $noProductsMessage ?? 'No products available in this subcategory.' }}</p>
  @endif
</main>
@endsection

@push('scripts')
<script>
$(function(){
  console.log('Filter script initialized');

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
  $('#price-from, #price-to').on('change input', function() {
    console.log('Price filter changed');
    var priceFrom = $('#price-from').val();
    var priceTo = $('#price-to').val();
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
    console.log('New URL:', url.toString());
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
