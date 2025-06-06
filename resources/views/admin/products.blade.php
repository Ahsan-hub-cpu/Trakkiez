@extends('layouts.admin')

@section('content')
<style>
    .table-striped th:nth-child(1), .table-striped td:nth-child(1) {
        width: 100px;   
    }
    .table-striped th:nth-child(2), .table-striped td:nth-child(2) {
        width: 250px;   
    }
    .table-striped th:nth-child(10), .table-striped td:nth-child(10) {
        width: 100px;   
    }
    .size-chart-images, .gallery-images {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    .size-chart-images img, .gallery-images img {
        max-width: 50px;
        height: auto;
    }
</style>
<div class="main-content-inner">                            
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Products</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>                                                                           
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Products</div>
                </li>
            </ul>
        </div>
        
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name" tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}"><i class="icon-plus"></i>Add new</a>
            </div>
            <div class="table-responsive">
                @if(session()->has('status'))
                    <p class="alert alert-success">{{session()->get('status')}}</p>
                @endif
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Brand</th>
                            <th>Size</th>
                            <th>Size Chart</th>
                            <th>Featured</th>
                            <th>Stock</th>
                            <th>Quantity</th>
                            <th>Gallery</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>
                                <div class="flex items-center">
                                    <div class="mr-3">
                                        @if($product->image && file_exists(base_path('uploads/products/thumbnails/' . $product->image)))
                                            <img src="{{asset('uploads/products/thumbnails/' . $product->image)}}" alt="{{$product->name}}" class="image">
                                        @else
                                            <span>Main Image Missing: {{$product->image ?? 'Not set'}}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="#" class="body-title-2">{{$product->name}}</a>
                                        <div class="text-tiny mt-3">{{$product->slug}}</div>
                                    </div>
                                </div>
                            </td>
                            <td>PKR {{$product->regular_price}}</td>
                            <td>PKR {{$product->sale_price ?? 'N/A'}}</td>
                            <td>{{$product->SKU}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>
                                @if($product->subcategory)
                                    {{$product->subcategory->name}}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{$product->brand->name}}</td>
                            <td>
                                @foreach($product->productVariations as $variation)
                                    <div>
                                        <span>({{$variation->size->name}})</span>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                @if($product->size_chart)
                                    <div class="size-chart-images">
                                        @foreach(explode(',', $product->size_chart) as $chart)
                                            @if(file_exists(base_path('uploads/products/thumbnails/' . $chart)))
                                                <img src="{{asset('uploads/products/thumbnails/' . $chart)}}" alt="Size Chart" class="image">
                                            @else
                                                <span>Chart Missing: {{$chart}}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{$product->featured == 0 ? "No" : "Yes"}}</td>
                            <td>{{$product->stock_status}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>
                                @if($product->images)
                                    <div class="gallery-images">
                                        @foreach(explode(',', $product->images) as $img)
                                            @if(file_exists(base_path('uploads/products/thumbnails/' . $img)))
                                                <img src="{{asset('uploads/products/thumbnails/' . $img)}}" alt="Gallery Image" class="image">
                                            @else
                                                <span>Gallery Image Missing: {{$img}}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{route('admin.product.edit', ['id' => $product->id])}}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{route('admin.product.delete', ['id' => $product->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="item text-danger delete">
                                            <i class="icon-trash-2"></i>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach                                  
                    </tbody>
                </table>
            </div>
            
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">                
                {{$products->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(function(){
            $(".delete").on('click', function(e){
                e.preventDefault();
                var selectedForm = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this record?",
                    type: "warning",
                    buttons: ["No!", "Yes!"],
                    confirmButtonColor: '#dc3545'
                }).then(function (result) {
                    if (result) {
                        selectedForm.submit();  
                    }
                });                             
            });
        });
    </script>    
@endpush