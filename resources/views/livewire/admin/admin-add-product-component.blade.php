@extends('layouts.admin-base')
@section('content')
<head>
    <link rel="stylesheet" type="text/css" href="/assets/css/form-bold.css"> 
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>

<div >
    <!-- Author: FormBold Team -->
    <div class="w-full">
        <div class="formbold-form-wrapper active">
            <div class="formbold-form-header">
                <h3>Create a product</h3>
                <button>
                    <a href="{{ route('admin.products')}}" class="btn btn-success">All Products</a>
                </button>
            </div>
            <form action="{{url('admin/store-product')}}" method="POST" enctype="multipart/form-data" class="formbold-chatbox-form">
            @csrf
                <div class="formbold-mb-5">
                    <label for="name" class="formbold-form-label">Product Name</label>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <input type="text" name="name" id="name" placeholder="Product Name" class="formbold-form-input"/>
                </div>

                <!-- <div class="formbold-mb-5">
                    <label for="short_description" class="formbold-form-label">Short Description</label>
                    <textarea type="text" name="short_description" id="short_description" placeholder="Short Description" class="formbold-form-input"></textarea>
                </div> -->

                <div class="formbold-mb-5">
                    <label for="description" class="formbold-form-label">Description </label>
                    <textarea name="description" id="description" placeholder="Description" class="formbold-form-input"></textarea>
                </div>

                <div class="formbold-mb-5">
                    <label for="regular_price" class="formbold-form-label">Regular Price </label>
                    @error('regular_price')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <input type="text" name="regular_price" id="regular_price" placeholder="00.00" class="formbold-form-input"/>
                </div>

                <div class="formbold-mb-5">
                    <label for="sale_price" class="formbold-form-label">Sale Price </label>
                    <input type="text" name="sale_price" id="sale_price" placeholder="00.00" class="formbold-form-input"/>
                </div>

                <div class="formbold-mb-5">
                    <label for="stock_status" class="formbold-form-label">Stock </label>
                    @error('stock_status')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <select name="stock_status" id="stock_status" style="width: 100%">
                        <option value="instock">In Stock</option>
                        <option value="outofstock">Out Of Stock</option>
                    </select>
                </div>

                <!-- <div class="formbold-mb-5">
                    <label for="quantity" class="formbold-form-label">Quantity </label>
                    @error('quantity')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <input type="text" name="quantity" id="quantity" placeholder="00" class="formbold-form-input"/>
                </div> -->

                <div class="formbold-mb-5">
                    <label for="color" class="formbold-form-label">Color </label>
                    @error('color')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <select style="width: 100%" name="color">
                        <option value="none" selected disabled hidden>Select an option</option> 
                        @foreach($colors as $color)
                        <option value="{{ $color}}">{{ $color }}</option>                    
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
                                <input  type="checkbox" name="size[]" value="{{ $size }}" onclick="setRequiredFieldQty('{{$i}}', $(this))"> {{ $size }}
                            </th>
                            <th style="padding-left: 20px;">
                                <input type="number" name="size_qty[]" id="qty_{{$i}}" placeholder="qty" class="formbold-form-input" style="width: 40%; height:70%; color:black; display:none;"> 
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
                        <option value="{{ $category->type .'|'. $category->subtype}}">{{ $category->type }}</option>
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
                    @error('product_image')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <input type="file" name="product_image[]" id="product_image" class="formbold-form-input" multiple>
                </div>

                <div>
                    <button class="formbold-btn w-full" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // functions here
    }); 

    $(document).on('change', '#category', function () {
        const subcatgories = $('#category').val().split('|')[1];
        const subcatgoriesArray = subcatgories.split(',');

        if(subcatgoriesArray.length > 0 && subcatgoriesArray[0] !== ''){
            $("#subcategories_list").html('');
            subcatgoriesArray.forEach(function(element) {
                $("#subcategories_list").append(
                    '<input type="checkbox" name="subcategories[]" value=' + element + ' multiple>' + element + '<br>'
                );
            });
            $('#subcategories_div').show();
        }else{

            $('#subcategories_div').hide();
        }

    }); 

    function setRequiredFieldQty(i, checkbox){
        if (checkbox.is(':checked')) {
            $('#qty_'+i).show();
            $('#qty_'+i).prop('required',true);
        } else {
            $('#qty_'+i).hide();
            $('#qty_'+i).prop('required',false);
        }
    }

</script>

@endsection
