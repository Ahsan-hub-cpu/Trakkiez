@extends('layouts.app')
@section('content')
<style>

  .filled-heart { color: orange; }
  .slideshow-bg { position: relative; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; }
  .slideshow-bg__img { width: 100%; height: 100%; object-fit: contain; }
  /*.category-header {*/
  /*  border-bottom: 1px solid #e0e0e0;*/
  /*  background-color: #f8f9fa;*/
  /*}*/
  /*.category-link {*/
  /*  padding: 8px 12px;*/
  /*  display: inline-block;*/
  /*  transition: all 0.3s ease;*/
  /*}*/
  /*.category-link:hover {*/
  /*  background-color: #ff6f61;*/
  /*  color: #fff !important;*/
  /*}*/
  /*.subcategories {*/
  /*  display: none;*/
  /*  position: absolute; */
  /*  top: 100%;*/
  /*  left: 0;*/
  /*  min-width: 200px;*/
  /*  z-index: 1000;*/
  /*  border-radius: 8px;*/
  /*  background-color: #fff; */
  /*  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
  /*}*/
  /*.list-inline-item:hover .subcategories {*/
  /*  display: block;*/
  /*}*/
  /*.subcategories li {*/
  /*  margin: 5px 0;*/
  /*}*/
  /*.subcategories a:hover {*/
  /*  color: #ff6f61 !important;*/
  /*}*/
  /*.hover-bg:hover {*/
  /*  background-color: #f8f9fa;*/
  /*  color: #ff6f61 !important;*/
  /*}*/
 
  /*.category-header .list-inline {*/
  /*  display: flex;*/
  /*  justify-content: center;*/
  /*  flex-wrap: wrap;*/
  /*}*/
  /*.category-header .list-inline-item {*/
  /*  display: flex;*/
  /*  align-items: center;*/
  /*  margin: 0 10px; */
  /*}*/
  /*.category-header .list-inline-item a {*/
  /*  display: inline-block;*/
  /*  padding: 10px 15px;*/
  /*}*/
  /*.category-header .category-link, */
  /*.category-header .list-inline-item a {*/
  /*  text-align: center;*/
  /*  margin-bottom: 0;*/
  /*}*/
  
  .product-card { 
    background: transparent; 
    border: none; 
    transition: transform 0.2s ease; 
    width: 90%; 
    margin: 0 auto; 
  }
  .product-card:hover { 
    transform: translateY(-3px); 
  }

  .pc__img-wrapper { 
    overflow: hidden; 
    border-radius: 8px; 
    position: relative; 
  }

  .pc__img { 
    width: 100%; 
    height: 100%; 
    object-fit: contain;  
    border-radius: 8px; 
    transition: transform 0.3s ease; 
    image-rendering: crisp-edges; 
  }

  .product-card:hover .pc__img { 
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
  }
 
  .pc__img-wrapper:hover .primary-img { 
    opacity: 0; 
  }
  .pc__img-wrapper:hover .secondary-img { 
    opacity: 1; 
  }
  .pc__atc { font-size: 0.875rem; padding: 0.375rem 0.75rem; opacity: 0; transition: opacity 0.3s ease, background-color 0.3s ease; }
  .product-card:hover .pc__atc { opacity: 1; }
  .pc__btn-wl { opacity: 0; transition: opacity 0.3s ease; }
  .product-card:hover .pc__btn-wl { opacity: 1; }
  .pc__title { font-size: 1rem; font-weight: 500; color: #333; transition: color 0.3s ease; }
  .pc__title:hover { color: #ff6f61; }
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
  /* .trakkiez-category-header {*/
  /*  position: relative;*/
  /*  background: white;*/
  /*  box-shadow: 0 2px 4px rgba(0,0,0,0.05);*/
  /*  border-bottom: 1px solid #e0e0e0;*/
  /*}*/
  /*.trakkiez-category-list {*/
  /*  display: flex;*/
  /*  align-items: center;*/
  /*  justify-content: center;*/
  /*  padding: 0;*/
  /*  margin: 0;*/
  /*  list-style: none;*/
  /*}*/
  
  /* Mobile Styles */
  @media (max-width: 768px) {
   
  /*} .trakkiez-category-header {*/
  /*    overflow-x: auto;*/
  /*    -webkit-overflow-scrolling: touch;*/
  /*    scrollbar-width: none;*/
  /*    -ms-overflow-style: none;*/
  /*  }*/
  /*  .trakkiez-category-header::-webkit-scrollbar {*/
  /*    display: none;*/
  /*  }*/
  /*  .trakkiez-category-list {*/
  /*    flex-wrap: nowrap;*/
  /*    justify-content: flex-start;*/
  /*    padding: 0 15px;*/
  /*    width: auto;*/
  /*    min-width: min-content;*/
  /*  }*/
  /*  .trakkiez-category-item {*/
  /*    flex: 0 0 auto;*/
  /*    position: relative;*/
  /*  }*/
  /*  .trakkiez-subcategories {*/
  /*    position: absolute;*/
  /*    top: 100%;*/
  /*    left: 0;*/
  /*    min-width: 200px;*/
  /*    background: white;*/
  /*    box-shadow: 0 4px 12px rgba(0,0,0,0.1);*/
  /*    border-radius: 8px;*/
  /*    z-index: 1000;*/
  /*    margin-top: 5px;*/
  /*  }*/
  /*  .trakkiez-category-link[data-has-dropdown].active::after {*/
  /*    transform: rotate(-135deg);*/
  /*  }*/
  /*}*/

  /* Desktop Styles */
  /*@media (min-width: 769px) {*/
  /*  .trakkiez-category-list {*/
  /*    flex-wrap: wrap;*/
  /*    gap: 10px;*/
  /*  }*/
  /*}*/

  /*.trakkiez-category-item {*/
  /*  position: relative;*/
  /*  margin: 0 5px;*/
  /*}*/
  /*.trakkiez-category-link {*/
  /*  display: flex;*/
  /*  align-items: center;*/
  /*  padding: 12px 20px;*/
  /*  color: #333;*/
  /*  text-decoration: none;*/
  /*  border-radius: 4px;*/
  /*  transition: all 0.3s ease;*/
  /*  font-weight: 500;*/
  /*  position: relative;*/
  /*  cursor: pointer;*/
  /*  white-space: nowrap;*/
  /*}*/
  /*.trakkiez-category-link:hover {*/
  /*  background-color: #ff6f61;*/
  /*  color: #fff;*/
  /*}*/
  /*.trakkiez-subcategories {*/
  /*  display: none;*/
  /*  position: absolute;*/
  /*  top: 100%;*/
  /*  left: 0;*/
  /*  min-width: 200px;*/
  /*  background: white;*/
  /*  box-shadow: 0 4px 12px rgba(0,0,0,0.1);*/
  /*  border-radius: 8px;*/
  /*  z-index: 1000;*/
  /*  padding: 8px 0;*/
  /*  opacity: 0;*/
  /*  visibility: hidden;*/
  /*  transition: all 0.3s ease;*/
  /*}*/
  /*.trakkiez-subcategories.active {*/
  /*  display: block;*/
  /*  opacity: 1;*/
  /*  visibility: visible;*/
  /*}*/
  /*.trakkiez-subcategory-link {*/
  /*  display: block;*/
  /*  padding: 10px 20px;*/
  /*  color: #555;*/
  /*  text-decoration: none;*/
  /*  transition: all 0.2s ease;*/
  /*  font-size: 0.95em;*/
  /*  white-space: nowrap;*/
  /*}*/
  /*.trakkiez-subcategory-link:hover {*/
  /*  background-color: #f8f9fa;*/
  /*  color: #ff6f61;*/
  /*  padding-left: 25px;*/
  /*}*/
  
  /* Arrow indicator for dropdown */
  /*.trakkiez-category-link[data-has-dropdown]::after {*/
  /*  content: '';*/
  /*  display: inline-block;*/
  /*  width: 6px;*/
  /*  height: 6px;*/
  /*  border-right: 2px solid #666;*/
  /*  border-bottom: 2px solid #666;*/
  /*  margin-left: 8px;*/
  /*  transform: rotate(45deg);*/
  /*  transition: transform 0.2s ease;*/
  /*  position: relative;*/
  /*  top: -2px;*/
  /*}*/
  /*.trakkiez-category-link[data-has-dropdown].active::after {*/
  /*  transform: rotate(-135deg);*/
  /*  top: 0;*/
  /*  border-color: #fff;*/
  /*}*/
  /* Container styles */
  /*.container {*/
  /*  max-width: 1200px;*/
  /*  margin: 0 auto;*/
  /*  padding: 0 30px;*/
  /*}*/
  /* Animation for dropdown */
  /*@keyframes fadeInUp {*/
  /*  from {*/
  /*    opacity: 0;*/
  /*    transform: translate(-50%, 10px);*/
  /*  }*/
  /*  to {*/
  /*    opacity: 1;*/
  /*    transform: translate(-50%, 0);*/
  /*  }*/
  /*}*/
  /*.trakkiez-category-item:hover .trakkiez-subcategories {*/
  /*  animation: fadeInUp 0.3s ease forwards;*/
  /*}*/

  /*@media (max-width: 768px) {*/
  /*  @keyframes fadeInUp {*/
  /*    from {*/
  /*      opacity: 0;*/
  /*      transform: translate(-50%, 10px);*/
  /*    }*/
  /*    to {*/
  /*      opacity: 1;*/
  /*      transform: translate(-50%, 0);*/
  /*    }*/
  /*  }*/
</style>

<!--<div class="trakkiez-category-header bg-light py-3 shadow-sm mb-4">-->
<!--        <div class="container">-->
<!--        <ul class="trakkiez-category-list">-->
<!--            @foreach ($categories as $category)-->
<!--            <li class="trakkiez-category-item">-->
<!--                <a href="#" class="trakkiez-category-link" -->
<!--                   @if($category->subCategories->count() > 0) data-has-dropdown="true" @endif-->
<!--                   data-category="{{ $category->id }}">-->
<!--                  {{ $category->name }}-->
<!--                </a>-->
<!--                @if ($category->subCategories->count() > 0)-->
<!--                <ul class="trakkiez-subcategories" id="subcategories-{{ $category->id }}">-->
<!--                    @foreach ($category->subCategories as $subCategory)-->
<!--                      <li>-->
<!--                        <a href="{{ route('shop.index', ['subcategory' => $subCategory->id]) }}" -->
<!--                           class="trakkiez-subcategory-link">-->
<!--                          {{ $subCategory->name }}-->
<!--                        </a>-->
<!--                      </li>-->
<!--                    @endforeach-->
<!--                  </ul>-->
<!--                @endif-->
<!--              </li>-->
<!--            @endforeach-->
      
<!--            <li class="trakkiez-category-item">-->
<!--                <a href="{{ route('shop.index', ['filter' => 'hot-deals']) }}" class="trakkiez-category-link">-->
<!--                Hot Deals-->
<!--              </a>-->
<!--            </li>-->
<!--            <li class="trakkiez-category-item">-->
<!--                <a href="{{ route('shop.index', ['filter' => 'featured']) }}" class="trakkiez-category-link">-->
<!--                Featured Products-->
<!--              </a>-->
<!--            </li>-->
<!--            <li class="trakkiez-category-item">-->
<!--                <a href="{{ route('shop.index', ['filter' => 'new-arrivals']) }}" class="trakkiez-category-link">-->
<!--                New Arrivals-->
<!--              </a>-->
<!--            </li>-->
<!--          </ul>-->
<!--        </div>-->
<!--      </div>-->

<div class="container mb-4">
  <div class="row">
    <div class="col-md-3">
      <select id="size-filter" class="form-select">
        <option value="">Filter by Size</option>
        @foreach($sizes as $size)
          <option value="{{ $size->id }}" {{ request('size') == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-3">
      <button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#priceFilterModal">
          Filter by Price
      </button>
    </div>

    <div class="col-md-3">
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

@if(request()->has('subcategory') || request()->has('size') || request()->has('price_from') || request()->has('price_to') || request()->has('sort'))
  <div class="text-center mt-3">
    <a href="{{ route('shop.index') }}" class="btn btn-outline-dark">Clear Filter</a>
  </div>
@endif

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

<div class="container">
  <div class="products-grid row row-cols-1 row-cols-md-3 g-4 mt-4">
  @foreach($products as $product)
    <div class="col">
        <div class="product-card card h-100 border-0 bg-transparent">
            <div class="pc__img-wrapper position-relative">
                <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                    <img loading="lazy" src="{{ asset('uploads/products/' . $product->image) }}" 
                        alt="{{ $product->name }}" 
                        class="pc__img primary-img card-img-top rounded">
                    
                    @php
                        $galleryImages = explode(',', $product->images); // Split gallery images
                        $hoverImage = count($galleryImages) > 0 ? $galleryImages[0] : null; // Pick the first one
                    @endphp
                    @if($hoverImage)
                        <img loading="lazy" src="{{ asset('uploads/products/' . $hoverImage) }}" 
                            width="330" height="400" 
                            alt="{{ $product->name }}" 
                            class="secondary-img">
                    @endif
                </a>
            </a>
            @if($product->quantity <= 0)
              <div class="sold-out-badge">Sold Out</div>
            @endif
            @if($product->quantity > 0)
              @if(Cart::instance("cart")->content()->where('id', $product->id)->count() > 0)
                <a href="{{ route('cart.index') }}" class="pc__atc btn btn-sm btn-outline-dark position-absolute bottom-0 start-50 translate-middle-x mb-2">
                  Go to Cart
                </a>
              @else
                <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}">
                  @csrf
                  <input type="hidden" name="id" value="{{ $product->id }}" />
                  <input type="hidden" name="name" value="{{ $product->name }}" />
                  <input type="hidden" name="quantity" value="1" />
                  <input type="hidden" name="price" value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                </form>
              @endif
            @endif
          </div>
          <div class="card-body px-0 pb-0">
            <p class="pc__category text-muted small mb-1">{{ $product->category->name }}</p>
            <h6 class="pc__title card-title mb-2">
              <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}" class="text-dark text-decoration-none">
                {{ $product->name }}
              </a>
            </h6>
            <div class="product-card__price d-flex align-items-center mb-2">
              <span class="money price fw-bold">
                @if($product->sale_price)
                  <s class="text-muted me-2">PKR {{ $product->regular_price }}</s> PKR {{ $product->sale_price }}
                @else
                  PKR {{ $product->regular_price }}
                @endif
              </span>
            </div>
            @if(Cart::instance("wishlist")->content()->where('id', $product->id)->count() > 0)
              <form method="POST" action="{{ route('wishlist.remove', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="pc__btn-wl btn btn-link p-0 position-absolute top-0 end-0 mt-2 me-2" title="Remove from Wishlist">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="orange" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_heart" />
                  </svg>
                </button>
              </form>
            @else
              <form method="POST" action="{{ route('wishlist.add') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}" />
                <input type="hidden" name="name" value="{{ $product->name }}" />
                <input type="hidden" name="quantity" value="1" />
                <input type="hidden" name="price" value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                <button type="submit" class="pc__btn-wl btn btn-link p-0 position-absolute top-0 end-0 mt-2 me-2" title="Add To Wishlist">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_heart" />
                  </svg>
                </button>
              </form>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

@if(!request()->has('size') && !request()->has('price_from') && !request()->has('price_to') && !request()->has('sort') && !request()->has('subcategory'))
  <div class="divider"></div>
  <div class="flex items-center justify-between flex-wrap gap10 wgp pagination">
    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
  </div>
@endif

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
          <input type="number" class="form-control" id="price-from-modal" placeholder="Enter minimum price" value="{{ request('price_from') }}">
        </div>
        <div class="mb-3">
          <label for="price-to-modal" class="form-label">Price To</label>
          <input type="number" class="form-control" id="price-to-modal" placeholder="Enter maximum price" value="{{ request('price_to') }}">
        </div>
        <div class="mb-3">
          <small class="text-muted">Highest price is PKR {{ $maxPrice }}</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="apply-price-filter-modal">Apply</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
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

    // Your existing scripts
    $('#size-filter').on('change', function() {
        updateUrl('size', $(this).val());
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
});
      </script>
@endpush
