@extends('layouts.admin-base')
@section('content')
<head>
    <link rel="stylesheet" type="text/css" href="/assets/css/form-bold.css"> 
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>

<div class="formbold-main-wrapper">
    <!-- Author: FormBold Team -->
    <!-- Learn More: https://formbold.com -->
    <div class="w-full">
        <div class="formbold-form-wrapper active">
        <div class="formbold-form-header">
            <h3>Edit a product</h3>
            <button>
                <a href="{{ route('admin.products')}}" class="btn btn-success">All Products</a>
            </button>
        </div>
        <form action="{{url('admin/update-product')}}" method="POST" enctype="multipart/form-data" class="formbold-chatbox-form">
        @csrf
            <input type="text" name="id" id="id" value="{{$product->id}}" class="formbold-form-input" style="display:none;"/>

            <div class="formbold-mb-5">
                <label for="name" class="formbold-form-label">Product Name</label>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="text" name="name" id="name" value="{{$product->name}}" class="formbold-form-input"/>
            </div>

            <!-- <div class="formbold-mb-5">
                <label for="short_description" class="formbold-form-label">Short Description</label>
                <textarea type="text" name="short_description" id="short_description" class="formbold-form-input">{{$product->short_description}}</textarea>
            </div> -->

            <div class="formbold-mb-5">
                <label for="description" class="formbold-form-label">Description </label>
                <textarea name="description" id="description" class="formbold-form-input">{{$product->description}}</textarea>
            </div>

            <div class="formbold-mb-5">
                <label for="regular_price" class="formbold-form-label">Regular Price </label>
                @error('regular_price')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="text" name="regular_price" id="regular_price" value="{{$product->regular_price}}" class="formbold-form-input"/>
            </div>

            <div class="formbold-mb-5">
                <label for="sale_price" class="formbold-form-label">Sale Price </label>
                <input type="text" name="sale_price" id="sale_price" value="{{$product->sale_price}}" class="formbold-form-input"/>
            </div>

            <div class="formbold-mb-5">
                <label for="stock_status" class="formbold-form-label">Stock </label>
                @error('stock_status')
                    <div class="error">{{ $message }}</div>
                @enderror
                <select style="width: 100%" name="stock_status" id="stock_status">
                    <option value="instock">In Stock</option>
                    <option value="outofstock">Out Of Stock</option>
                </select>
            </div>
            <input type="text" id="stockValue" value="{{$product->stock_status}}" style="display:none;">

            <!-- <div class="formbold-mb-5">
                <label for="quantity" class="formbold-form-label">Quantity </label>
                @error('quantity')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="text" name="quantity" id="quantity" value="{{$product->quantity}}" class="formbold-form-input"/>
            </div> -->

            <div class="formbold-mb-5">
                <label for="color" class="formbold-form-label">Color </label>
                @error('color')
                    <div class="error">{{ $message }}</div>
                @enderror
                <select style="width: 100%" name=color>
                    <option value="none" disabled >Select an option</option> 
                    @foreach($colors as $color)
                    <option value="{{ $color }}" {{ ( $color == $product->color) ? 'selected' : '' }}> {{ $color }} </option>
                    @endforeach
                </select>
            </div>

            <div class="formbold-mb-5">
                <label for="size" class="formbold-form-label">Size </label>
                @error('size')
                    <div class="error">{{ $message }}</div>
                @enderror
                <fieldset>
                    <table>
                    @foreach($sizes as $i => $size)
                    <tr>
                        <th>
                            <input  type="checkbox" name="size[]" id="size_{{$i}}" value="{{ $size }}" onclick="setRequiredFieldQty('{{$i}}', $(this))" {{ ( isset($productSizes[$size]) ) ? 'checked' : ''}}> {{ $size }}
                        </th>
                        <th style="padding-left: 20px;">
                            @if(isset($productSizes[$size]))
                            <input type="number" name="size_qty[]" id="qty_{{$i}}" placeholder="qty" class="formbold-form-input" style="width: 40%; height:70%; color:black; display:none;" value="{{ $productSizes[$size] }}"> 
                            @else
                            <input type="number" name="size_qty[]" id="qty_{{$i}}" placeholder="qty" class="formbold-form-input" style="width: 40%; height:70%; color:black; display:none;"> 
                            @endif
                        </th>
                    </tr>    
                    @endforeach
                    </table>
                </fieldset>
            </div>

            <div class="formbold-mb-5">
                <label for="category" class="formbold-form-label">Category </label>
                @error('category')
                    <div class="error">{{ $message }}</div>
                @enderror
                <select class="category_class" name="category" id="category" style="width: 100%">
                    <option value="none" selected disabled hidden>Select an option</option> 
                    @foreach($categories as $category)
                    <option value="{{ $category->type .'|'. $category->subtype}}" {{ ( $category->type == $product->category) ? 'selected' : '' }}> {{ $category->type }} </option>
                    @endforeach
                </select>
            </div>

            <div class="formbold-mb-5" style="display: none;" id="subcategories_div">
                <label for="subcategories" class="formbold-form-label">Subcategories</label>
                <fieldset id="subcategories_list">
                </fieldset>
            </div>

            <div class="formbold-mb-5">
                <label for="product_image" class="formbold-form-label">Product Image </label>
                <input type="file" name="product_image" id="product_image" class="formbold-form-input"/>
                @if(isset($product->image))
                    @foreach($product->image as $image)
                    <img class="formbold-form-input" src="{{$image}}" width="120" style="margin-top:10px; width:30%;">
                    @endforeach
                @endif
            </div>

            <div>
                <button class="formbold-btn w-full" type="submit">Update</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>

    let sizes = <?php echo count($sizes); ?>

    $(document).ready(function(){
        var type = $('#stockValue').val();
        $('#stock_status').val(type);
        showQuanityField(sizes);
        setSubcategories();
    });

    $(document).on('change', '#category', function () {
        setSubcategories();
    }); 

    function setSubcategories(){
        const subcatgories = $('#category').val().split('|')[1];
        const subcatgoriesArray = subcatgories.split(',');
        const subcategoriesObj = "{{ $product->subcategories }}";
        const subcategoriesStr = subcategoriesObj.replace(/&quot;/g, '"')
        const productSubcategoriesArr = JSON.parse(subcategoriesStr);

        console.log(productSubcategoriesArr);

        if(subcatgoriesArray.length > 0 && subcatgoriesArray[0] !== ''){
            $("#subcategories_list").html('');
            subcatgoriesArray.forEach(function(element) {
                if(productSubcategoriesArr.includes(element)){
                    $("#subcategories_list").append(
                        '<input type="checkbox" name="subcategories[]" value=' + element  + ' multiple checked >' + element + '<br>'
                    );
                }else{
                    $("#subcategories_list").append(
                        '<input type="checkbox" name="subcategories[]" value=' + element  + ' multiple >' + element + '<br>'
                    );
                }
            });
            $('#subcategories_div').show();
        }else{

            $('#subcategories_div').hide();
        }
    }

    function setRequiredFieldQty(i, checkbox){
        if (checkbox.is(':checked')) {
            $('#qty_'+i).show();
            $('#qty_'+i).prop('required',true);
        } else {
            $('#qty_'+i).hide();
            $('#qty_'+i).prop('required',false);
        }
    }

    function showQuanityField(sizes){
        for (let i = 0; i < sizes; i++) {
            if($('#size_'+i).is(':checked')){
                $('#qty_'+i).show();
            }
        }
    }
</script>

@endsection
