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
                <h3>Add Product</h3>
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
                        <div class="text-tiny">Add product</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.store')}}">
                @csrf
                <div class="wg-box">
                    <!-- Product Name and Slug -->
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0" value="{{old('name')}}" aria-required="true">
                    </fieldset>
                    @error("name") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0" value="{{old('slug')}}" aria-required="true">
                    </fieldset>
                    @error("slug") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <div class="gap22 cols">
                        <!-- Category Selection -->
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="" name="category_id" id="category-Select">
                                    <option value="">Choose category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach                                                                 
                                </select>
                            </div>
                        </fieldset>
                        @error("category_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                        <!-- Subcategory Selection -->
                        <fieldset class="subcategory">
                            <div class="body-title mb-10">Subcategory <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="" name="subcategory_id" id="subcategorySelect">
                                    <option value="">Choose subcategory</option>
                                </select>
                            </div>
                        </fieldset>
                        @error("subcategory_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>

                    <!-- Brand and Description Fields -->
                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="" name="brand_id">
                                <option value="">Choose Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach                                  
                            </select>
                        </div>
                    </fieldset>
                    @error("brand_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0" aria-required="true">{{old('short_description')}}</textarea>
                    </fieldset>
                    @error("short_description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true">{{old('description')}}</textarea>
                    </fieldset>
                    @error("description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>

                <!-- Image Upload Section -->
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">                            
                                <img src="{{asset('images/upload/upload-1.png')}}" class="effect8" alt="">
                            </div>
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
                            <div id ="galUpload" class="item up-load">
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
                        <div class="body-title">Upload Size Chart Image</div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="sizeChartPreview" style="display:none">                            
                                <img src="{{asset('images/upload/upload-1.png')}}" class="effect8" alt="Size Chart">
                            </div>
                            <div id="upload-size-chart" class="item up-load">
                                <label class="uploadfile" for="sizeChartFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your size chart here or select <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="sizeChartFile" name="size_chart" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset> 
                    @error("size_chart") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <div class="cols gap22">
                        <!-- Price, SKU, and Quantity Fields -->
                        <fieldset class="name">                                                  
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter regular price" name="regular_price" tabindex="0" value="{{old('regular_price')}}" aria-required="true">                                              
                        </fieldset>
                        @error("regular_price") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price</div>
                            <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price" tabindex="0" value="{{old('sale_price')}}">                                              
                        </fieldset>
                        @error("sale_price") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>

                    <div class="cols gap22">
                        <!-- Stock and Featured Fields -->
                        <fieldset class="name">                                                  
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU" tabindex="0" value="{{old('SKU')}}" aria-required="true">                                              
                        </fieldset>
                        @error("SKU") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity" tabindex="0" value="{{old('quantity')}}" aria-required="true">                                              
                        </fieldset>
                        @error("quantity") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status" required>
                                    <option value="instock">In Stock</option>
                                    <option value="outofstock">Out of Stock</option>                                                          
                                </select>
                            </div>                                                 
                        </fieldset>
                        @error("stock_status") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>                                                          
                                </select>
                            </div>
                        </fieldset>
                        @error("featured") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>

                    <!-- Sizes Fieldset -->
                    <fieldset class="sizes">
                        <div class="body-title mb-10">Sizes <span class="tf-color-1">*</span></div>
                        <div class="checkbox-group">
                            @foreach ($sizes as $size)
                                <label>
                                    <input type="checkbox" name="sizes[]" value="{{ $size->id }}" class="size-checkbox"> 
                                    {{ $size->name }}
                                </label>
                                <input type="number" name="size_stock[{{$size->id}}]" class="size-stock-input hidden" placeholder="Stock Quantity">
                                <br>
                            @endforeach
                        </div>
                    </fieldset>
                    @error("sizes") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Add product</button>                                            
                    </div>
                </div>
            </form>
            
        </div>

    </div>

@endsection

@push("scripts")
<script>
    $(function() {
        $('#category-Select').on('change', function() {
            let categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: "{{ url('/admin/getSubcategories') }}/" + categoryId,
                    method: 'GET',
                    success: function(response) {
                        console.log(response); 
                        $('#subcategorySelect').empty().append('<option value="">Select Subcategory</option>');

                        if (response.subcategories.length > 0) {
                            $.each(response.subcategories, function(index, subcategory) {
                                $('#subcategorySelect').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                            });
                        } else {
                            $('#subcategorySelect').append('<option value="">No subcategories available</option>');
                        }
                    },
                    error: function() {
                        alert('Error fetching subcategories.');
                    }
                });
            } else {
                $('#subcategorySelect').empty().append('<option value="">Select Subcategory</option>');
            }
        });

        $("#myFile").on("change", function(e) {
            const photoInp = $("#myFile");
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });

        $("#gFile").on("change", function(e) {
            $(".gitems").remove();
            const gFile = $("#gFile");
            const gphotos = this.files;
            $.each(gphotos, function(key, val) {
                $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}" alt=""></div>`);
            });
        });

        $("#sizeChartFile").on("change", function(e) {
            const [file] = this.files;
            if (file) {
                $("#sizeChartPreview img").attr('src', URL.createObjectURL(file));
                $("#sizeChartPreview").show();
            }
        });

        $("input[name='name']").on("change", function() {
            $("input[name='slug']").val(StringToSlug($(this).val()));
        });

        $(".size-checkbox").on("change", function() {
            let stockInput = $(this).closest("label").next(".size-stock-input");
            if ($(this).is(":checked")) {
                stockInput.removeClass("hidden").attr("required", true);
            } else {
                stockInput.addClass("hidden").val("").removeAttr("required");
            }
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
            .replace(/[^\w ]+/g, "")  
            .replace(/ +/g, "-");
        }
    });
</script>
@endpush