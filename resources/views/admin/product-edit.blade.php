@extends('layouts.admin')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- main-content-wrap -->
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{route('admin.products')}}"><div class="text-tiny">Products</div></a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit product</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.update')}}">
            <input type="hidden" name="id" value="{{$product->id}}" />
            @csrf
            @method("PUT")
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0" value="{{$product->name}}" aria-required="true" required>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>
                @error("name") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0" value="{{$product->slug}}" aria-required="true" required>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>
                @error("slug") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="category_id" id="category_id">
                                <option value="">Choose category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{$product->category_id == $category->id ? "selected" : ""}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error("category_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="subcategory">
                        <div class="body-title mb-10">Subcategory <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="subcategory_id" id="subcategory_id">
                                <option value="">Choose subcategory</option>
                                @foreach ($product->category->subcategories as $subcategory)
                                    <option value="{{$subcategory->id}}" {{$product->subcategory_id == $subcategory->id ? "selected" : ""}}>{{$subcategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error("subcategory_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>

                <fieldset class="brand">
                    <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                    <div class="select">
                        <select name="brand_id">
                            <option value="">Choose Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{$brand->id}}" {{$product->brand_id == $brand->id ? "selected" : ""}}>{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>
                @error("brand_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0" aria-required="true" required>{{$product->short_description}}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>
                @error("short_description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true" required>{{$product->description}}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>
                @error("description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
            </div>

            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        @if($product->image)
                            <div class="item" id="imgpreview">
                                <img src="{{asset('uploads/products/' . $product->image)}}" class="effect8" alt="Main Image">
                            </div>
                        @else
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="{{asset('images/upload/upload-1.png')}}" class="effect8" alt="Main Image">
                            </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error("image") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
                        @if($product->images)
                            @foreach(explode(",", $product->images) as $img)
                                <div class="item gitems">
                                    <img src="{{asset('uploads/products/' . $img)}}" class="effect8" alt="Gallery Image">
                                </div>
                            @endforeach
                        @endif
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error("images") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset>
                    <div class="body-title mb-10">Upload Size Chart Images</div>
                    <div class="upload-image mb-16">
                        @if($product->size_chart)
                            @foreach(explode(",", $product->size_chart) as $chart)
                                <div class="item sizeChartItems">
                                    <img src="{{asset('uploads/products/' . $chart)}}" class="effect8" alt="Size Chart Image">
                                </div>
                            @endforeach
                        @endif
                        <div id="sizeChartUpload" class="item up-load">
                            <label class="uploadfile" for="sizeChartFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your size chart images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="sizeChartFile" name="size_charts[]" accept="image/*" multiple>
                            </label>
                        </div>
                    </div>
                    <div class="remove-size-chart">
                        <label>
                            <input type="checkbox" name="remove_size_charts" value="1">
                            Remove existing size chart images
                        </label>
                    </div>
                </fieldset>
                @error("size_charts") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter regular price" name="regular_price" tabindex="0" value="{{$product->regular_price}}" aria-required="true" required>
                    </fieldset>
                    @error("regular_price") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price</div>
                        <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price" tabindex="0" value="{{$product->sale_price}}"/>
                    </fieldset>
                    @error("sale_price") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU" tabindex="0" value="{{$product->SKU}}" aria-required="true" required>
                    </fieldset>
                    @error("SKU") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity" tabindex="0" value="{{$product->quantity}}" aria-required="true" required>
                    </fieldset>
                    @error("quantity") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock</div>
                        <div class="select mb-10">
                            <select name="stock_status">
                                <option value="instock" {{$product->stock_status == "instock" ? "selected" : ""}}>In Stock</option>
                                <option value="outofstock" {{$product->stock_status == "outofstock" ? "selected" : ""}}>Out of Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    @error("stock_status") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <div class="select mb-10">
                            <select name="featured">
                                <option value="0" {{$product->featured == "0" ? "selected" : ""}}>No</option>
                                <option value="1" {{$product->featured == "1" ? "selected" : ""}}>Yes</option>
                            </select>
                        </div>
                    </fieldset>
                    @error("featured") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>

                <fieldset class="sizes">
                    <div class="body-title mb-10">Sizes & Stock Quantity <span class="tf-color-1">*</span></div>
                    <div class="checkbox-group">
                        @foreach ($sizes as $size)
                            @php
                                $variation = $product->productVariations->where('size_id', $size->id)->first();
                                $stockQuantity = $variation ? $variation->quantity : '';
                            @endphp
                            <div class="size-item">
                                <label>
                                    <input type="checkbox" name="sizes[]" value="{{ $size->id }}" class="size-checkbox" {{ $variation ? 'checked' : '' }}>
                                    {{ $size->name }}
                                </label>
                                <input type="number" name="size_stock[{{ $size->id }}]" placeholder="Stock Quantity" class="size-stock-input" value="{{ $stockQuantity }}" {{ $variation ? '' : 'disabled' }}>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
                @error("sizes") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Save product</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
</div>
<!-- /main-content-wrap -->
@endsection

@push("scripts")
<script>
    $(function(){
        // Update subcategory options based on category
        $("#category_id").on("change", function() {
            var category_id = $(this).val();
            $.ajax({
                url: "/admin/getSubcategories/" + category_id,
                method: "GET",
                success: function(response) {
                    var subcategorySelect = $("#subcategory_id");
                    subcategorySelect.empty();
                    subcategorySelect.append('<option value="">Choose subcategory</option>');
                    response.subcategories.forEach(function(subcategory) {
                        subcategorySelect.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                    });
                },
                error: function() {
                    alert('Error fetching subcategories.');
                }
            });
        });

        // Handle main image upload preview
        $("#myFile").on("change", function(e) {
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });

        // Handle gallery images upload preview
        $("#gFile").on("change", function(e) {
            $(".gitems").remove();
            const gphotos = this.files;
            $.each(gphotos, function(key, val) {
                $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}" alt="Gallery Image"></div>`);
            });
        });

        // Handle size chart images upload preview
        $("#sizeChartFile").on("change", function(e) {
            $(".sizeChartItems").remove();
            const sizeChartPhotos = this.files;
            $.each(sizeChartPhotos, function(key, val) {
                $("#sizeChartUpload").prepend(`<div class="item sizeChartItems"><img src="${URL.createObjectURL(val)}" alt="Size Chart Image"></div>`);
            });
            $("input[name='remove_size_charts']").prop('checked', false);
        });

        // Define existing size chart images
        const existingSizeCharts = [
            @if($product->size_chart)
                @foreach(explode(",", $product->size_chart) as $chart)
                    "{{asset('uploads/products/' . $chart)}}",
                @endforeach
            @endif
        ];

        // Handle remove size chart checkbox
        $("input[name='remove_size_charts']").on("change", function() {
            if ($(this).is(":checked")) {
                $(".sizeChartItems").remove();
                $("#sizeChartFile").val('');
            } else {
                // Restore new uploads if present
                if ($("#sizeChartFile")[0].files.length > 0) {
                    $(".sizeChartItems").remove();
                    const sizeChartPhotos = $("#sizeChartFile")[0].files;
                    $.each(sizeChartPhotos, function(key, val) {
                        $("#sizeChartUpload").prepend(`<div class="item sizeChartItems"><img src="${URL.createObjectURL(val)}" alt="Size Chart Image"></div>`);
                    });
                } else {
                    // Restore existing size chart images
                    $(".sizeChartItems").remove();
                    existingSizeCharts.forEach(function(chart) {
                        $("#sizeChartUpload").prepend(`<div class="item sizeChartItems"><img src="${chart}" alt="Size Chart Image"></div>`);
                    });
                }
            }
        });

        // Handle size checkbox toggle for stock input
        $(".size-checkbox").on("change", function() {
            var stockInput = $(this).closest(".size-item").find(".size-stock-input");
            if ($(this).is(":checked")) {
                stockInput.prop("disabled", false).attr("required", true);
            } else {
                stockInput.prop("disabled", true).val('').removeAttr("required");
            }
        });

        // Auto generate slug
        $("input[name='name']").on("change", function() {
            $("input[name='slug']").val(StringToSlug($(this).val()));
        });
    });

    function StringToSlug(Text) {
        return Text.toLowerCase()
            .replace(/[^\w ]+/g, "")
            .replace(/ +/g, "-");
    }
</script>
@endpush