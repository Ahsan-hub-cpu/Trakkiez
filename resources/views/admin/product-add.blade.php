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

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{route('admin.products')}}"><div class="text-tiny">Products</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Add product</div></li>
            </ul>
        </div>

        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.store')}}">
            @csrf

            {{-- Basic Info --}}
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                    <input type="text" name="name" placeholder="Enter product name" value="{{old('name')}}" required>
                </fieldset>
                @error("name") <span class="alert alert-danger">{{$message}}</span> @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input type="text" name="slug" placeholder="Enter product slug" value="{{old('slug')}}" required>
                </fieldset>
                @error("slug") <span class="alert alert-danger">{{$message}}</span> @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">SKU</div>
                    <input type="text" name="SKU" placeholder="Enter SKU" value="{{old('SKU')}}">
                </fieldset>
                @error("SKU") <span class="alert alert-danger">{{$message}}</span> @enderror

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="category_id" id="category-Select" required>
                                <option value="">Choose category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error("category_id") <span class="alert alert-danger">{{$message}}</span> @enderror

                    <fieldset class="subcategory">
                        <div class="body-title mb-10">Subcategory <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="subcategory_id" id="subcategorySelect" required>
                                <option value="">Choose subcategory</option>
                                <!-- Populated via JS -->
                            </select>
                        </div>
                    </fieldset>
                    @error("subcategory_id") <span class="alert alert-danger">{{$message}}</span> @enderror
                </div>

                <fieldset class="brand">
                    <div class="body-title mb-10">Brand</div>
                    <div class="select">
                        <select name="brand_id">
                            <option value="">Choose Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{$brand->id}}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>
                @error("brand_id") <span class="alert alert-danger">{{$message}}</span> @enderror

                <fieldset class="description">
                    <div class="body-title mb-10">Description</div>
                    <textarea name="description" placeholder="Description">{{old('description')}}</textarea>
                </fieldset>
                @error("description") <span class="alert alert-danger">{{$message}}</span> @enderror
            </div>

            {{-- Images --}}
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Main Image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="{{asset('images/upload/upload-1.png')}}" alt="Preview">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="main_image" accept="image/*" required>
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error("main_image") <span class="alert alert-danger">{{$message}}</span> @enderror

                <fieldset>
                    <div class="body-title mb-10">Gallery Images</div>
                    <div class="upload-image mb-16">
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="text-tiny">Drop your images here or <span class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="gallery_images[]" accept="image/*" multiple>
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error("gallery_images") <span class="alert alert-danger">{{$message}}</span> @enderror
            </div>

            {{-- Price / Stock --}}
            <div class="wg-box">
                <div class="cols gap22">
                    <fieldset>
                        <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                        <input type="text" name="regular_price" placeholder="Enter regular price" value="{{old('regular_price')}}" required>
                    </fieldset>
                    @error("regular_price") <span class="alert alert-danger">{{$message}}</span> @enderror

                    <fieldset>
                        <div class="body-title mb-10">Sale Price</div>
                        <input type="text" name="sale_price" placeholder="Enter sale price" value="{{old('sale_price')}}">
                    </fieldset>
                    @error("sale_price") <span class="alert alert-danger">{{$message}}</span> @enderror
                </div>

                <fieldset>
                    <div class="body-title mb-10">Stock Status</div>
                    <select name="stock_status" required>
                        <option value="in_stock" {{ old('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="out_of_stock" {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </fieldset>
                @error("stock_status") <span class="alert alert-danger">{{$message}}</span> @enderror

                <fieldset>
                    <div class="body-title mb-10">Featured</div>
                    <select name="featured">
                        <option value="0" {{ old('featured') == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('featured') == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </fieldset>
            </div>

            {{-- Colours + Stock --}}
            <div class="wg-box">
                <fieldset class="colours">
                    <div class="body-title mb-10">Colours & Stock Quantity <span class="tf-color-1">*</span></div>
                    <div class="checkbox-group">
                        @foreach ($colours as $colour)
                            <div class="colour-item">
                                <label>
                                    <input type="checkbox" name="colours[]" value="{{ $colour->id }}" class="colour-checkbox" {{ is_array(old('colours')) && in_array($colour->id, old('colours')) ? 'checked' : '' }}>
                                    {{ $colour->name }}
                                </label>
                                <input type="number" name="colour_stock[{{ $colour->id }}]" placeholder="Stock Quantity" value="{{ old('colour_stock.' . $colour->id) }}" class="colour-stock-input" {{ is_array(old('colours')) && in_array($colour->id, old('colours')) ? '' : 'disabled' }}>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>

            <div class="cols gap10">
                <button class="tf-button w-full" type="submit">Add product</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push("scripts")
<script>
    $(function() {
        // Category -> Subcategory
        $('#category-Select').on('change', function() {
            let categoryId = $(this).val();
            if (categoryId) {
                $.get("{{ url('/admin/getSubcategories') }}/" + categoryId, function(response) {
                    $('#subcategorySelect').empty().append('<option value="">Select Subcategory</option>');
                    if (response.subcategories.length > 0) {
                        $.each(response.subcategories, function(_, sub) {
                            $('#subcategorySelect').append('<option value="'+sub.id+'">'+sub.name+'</option>');
                        });
                    } else {
                        $('#subcategorySelect').append('<option value="">No subcategories available</option>');
                    }
                });
            } else {
                $('#subcategorySelect').empty().append('<option value="">Select Subcategory</option>');
            }
        });

        // Main image preview
        $("#myFile").on("change", function() {
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });

        // Gallery preview
        $("#gFile").on("change", function() {
            $(".gitems").remove();
            $.each(this.files, function(_, file) {
                $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(file)}" alt=""></div>`);
            });
        });

        // Auto slug
        $("input[name='name']").on("change", function() {
            $("input[name='slug']").val($(this).val().toLowerCase().replace(/[^\w ]+/g,"").replace(/ +/g,"-"));
        });

        // Enable stock input with colour checkbox
        $(".colour-checkbox").on("change", function() {
            let stockInput = $(this).closest(".colour-item").find(".colour-stock-input");
            if ($(this).is(":checked")) {
                stockInput.prop("disabled", false).attr("required", true);
            } else {
                stockInput.prop("disabled", true).val('').removeAttr("required");
            }
        });
    });
</script>
@endpush