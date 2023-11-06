@extends('layouts.base')
@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.touchSwipe.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<style>
    p {
        margin-top:8px;
        margin-bottom: 8px;
    }
    .dropdown {
        display: inline-block;
        position: relative;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #FFFFFF;
        width: 100%;
        overflow: auto;
        box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.4);
    }
    .dropdown:hover .dropdown-content {
        display: block;
    }
    .dropdown-content a {
        display: block;
        color: #6a6868;
        padding: 5px;
        text-decoration: none;
    }
    .dropdown-content a:hover {
        color: #FFFFFF;
        background-color: #00A4BD;
    }
    .dropdown-container{
        height:28px; 
        width:200px; 
        background: white; 
        border-radius:4px; 
        color: #6a6868;
        display: flex;
        justify-content: center;
        align-items: center;
        border-style: solid;
        border-width: thin;
    }
    .top {
        z-index: 10;
    }
    .container{
        max-width: 85%;
    }
    .border-style{
        margin: 35px 20px 0px 20px;
        /* border: solid; */
        border-radius: 5px;
        border-color: #f6f5f5;
        padding: 0px 0px 10px 0px;
        border-width: medium;
    }
    .center-button{
        margin: 10px 40px 0px 40px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .center-span{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .name-span{
        height: 35px;
        padding: 0px 10px 0px 10px;
    }
    .hovertext {
        position: relative;
        z-index: 5;
    }

    .hovertext:before {
        content: attr(data-hover);
        visibility: hidden;
        opacity: 0;
        width: 200px;
        height: max-content;
        background-color: rgb(104, 104, 104);
        font-size: 14px;
        color: rgb(255, 253, 253);
        text-align: center;
        border-radius: 5px;
        padding: 5px 5px;
        transition: opacity 1s ease-in-out;
        transform: scale(0.9);
        position: absolute;
        z-index: 1;
        left: -80px;
        top: 50%;
    }

    .hovertext:hover:before {
        opacity: 1;
        visibility: visible;
    }
    
    @media only screen and (min-width: 500px) and (max-width: 1100px){
        .center-button{
            margin: 0px 15px 0px 15px;
        }
        .border-style{
            margin: 35px 5px 0px 5px;
        }
        .name-span{
            height: 70px;
        }
    }

    @media only screen and (min-width: 350px) and (max-width: 450px){
        .name-span{
            height: 70px;
        }
        .next, .prev{
            top: 30%;
        }
    }

    @media only screen and (min-width: 500px) and (max-width: 700px){
        .name-span{
            height: 70px;
        }
        .next, .prev{
            top: 15%;
        }
    }

    @media only screen and (min-width: 700px) and (max-width: 1100px){
        .name-span{
            height: 90px;
        }
        .product-grid {
            margin-left: 5px;
        }
        .next, .prev{
            top: 25%;
        }
    }

    @media only screen and (min-width: 1400px) and (max-width: 1600px){
        /* Para hacer de 4 columnas */
        /* .product-list li { 
            width: 25%;
        } */
        .product .product-thumnail, .product-style-2 .product-thumnail {
            height: 450px;
        }
        /* Para hacer de 4 columnas */
        /* .product-grid {
            column-gap: 5px;
        } */
    }

    @media only screen and (min-width: 1600px) {
        /* .product-list li {
            width: 25%;
        } */
        .product .product-thumnail, .product-style-2 .product-thumnail {
            height: 500px;
        }
        /* .product-grid {
            column-gap: 0px;
        } */
    }

    @media only screen and (min-width: 1000px){
        .col-lg-3 {
            flex: 0 0 auto;
            width: 20%;
        }
        .col-lg-9 {
            flex: 0 0 auto;
            width: 79%;
        }
    }

    @media only screen and (min-width: 2000px) {
        .product .product-thumnail, .product-style-2 .product-thumnail {
            height: 450px;
        }
    }

    @media only screen and (min-width: 3000px) {
        .product .product-thumnail, .product-style-2 .product-thumnail {
            height: 650px;
        }
    }

</style>

<?php
    $no_size = 'No Size';
    $page = $_SERVER['REQUEST_URI']; 
    $page = str_replace('/','',$page);
    $page = str_replace('=','|',$page);
    $page = str_replace('?','-',$page);
?>

<!--main area-->
<div id="main" class="container">

    <div class="wrap-breadcrumb">
        <ul>
            <li class="item-link"><a href="/" class="link">home</a></li>
            <li class="item-link"><span>Products</span></li>
        </ul>
    </div>
    <div class="row">

        <!--  start left sitebar -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">

            <!-- Categories widget-->
            <div class="widget mercado-widget categories-widget">
                <h2 class="widget-title">Categories</h2>
                <div class="widget-content">
                    <ul class="list-category">
                        @foreach($categories as $x => $category)
                            @if(is_array($category))
                            <li class="category-item has-child-cate">
                                <a href="#" class="cate-link" onclick="openMenu('{{$x}}')">{{$category['type']}}</a>
                                <span class="toggle-control" onclick="openMenu('{{$x}}')"><b>+</b></span>
                                <ul class="sub-cate" id="sub-cate{{$x}}">
                                    @foreach($category['subtype'] as $subcategories)
                                    <li class="category-item"><a href="{{ url('/products-sort',['parameter'=>$sortSelected,'category'=>$category['type'].'|'.$subcategories,'color'=>$colorSelected ]) }}" class="cate-link">{{$subcategories}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @else
                            <li class="category-item"> <a href="{{ url('/products-sort',['parameter'=>$sortSelected,'category'=>$category,'color'=>$colorSelected ]) }}" class="cate-link">{{$category}}</a> </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- Categories widget-->

            <!-- Colors widget -->
            <!-- <div class="widget mercado-widget filter-widget">
                <h2 class="widget-title">Color</h2>
                <div class="widget-content">
                    <ul class="list-style vertical-list has-count-index">
                        @foreach($colors as $key => $color)
                        <li class="list-item">
                            <a class="filter-link" 
                            href="{{ url('/products-sort',['parameter'=>$sortSelected, 'category'=>$categorySelected, 'color'=>$color['color'] ]) }}" > {{ $color['color'] }} <span>({{ $color['color_count'] }})</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div> -->
            <!-- Color -->

            <!-- left banner section -->
            <div class="widget-banner">
                <a href="/create-bracelet">
                 <figure><img src="/assets/images/BANNER_LEFT.png" width="270" height="331" alt=""></figure>
                </a>
            </div>
            <!-- left banner section -->

            <!-- Popular products -->
            <!-- <div class="widget mercado-widget widget-product">
                <h2 class="widget-title">Popular Products</h2>
                <div class="widget-content">
                    <ul class="products">
                        <li class="product-item">
                            <div class="product product-widget-style">
                                <div class="thumbnnail">
                                    <a href="detail.html" title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                        <figure><img src="assets/images/products/digital_01.jpg" alt=""></figure>
                                    </a>
                                </div>
                                <div class="product-info">
                                    <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker...</span></a>
                                    <div class="wrap-price"><span class="product-price">$168.00</span></div>
                                </div>
                            </div>
                        </li>

                        <li class="product-item">
                            <div class="product product-widget-style">
                                <div class="thumbnnail">
                                    <a href="detail.html" title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                        <figure><img src="assets/images/products/digital_17.jpg" alt=""></figure>
                                    </a>
                                </div>
                                <div class="product-info">
                                    <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker...</span></a>
                                    <div class="wrap-price"><span class="product-price">$168.00</span></div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div> -->
            <!-- brand widget-->

        </div>
        <!--end left sitebar-->

        <!--start main products area-->
        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">

            <div id="productSection" class="banner-shop" >
                <a class="banner-link">
                    <figure><img src="/assets/img/cover_products.png"></figure>
                </a>
            </div>

            <div id="productSection" class="wrap-shop-control">

                <h1 class="shop-title">Products & More</h1>

                <div class="wrap-right">

                    <div class="dropdown sort-item orderby">
                        @if(empty($sortLabel))
                        <div class="dropdown-container">Default sorting &nbsp;<i class="fa fa-chevron-down"></i></div>
                        @else
                        <div class="dropdown-container">{{ $sortLabel }}&nbsp;<i class="fa fa-chevron-down"></i></div>
                        @endif
                        <div class="dropdown-content top">
                            <a href="{{ url('/products-sort',['parameter'=>'default','category'=>$categorySelected,'color'=>$colorSelected ]) }}">Default sorting</a>
                            <a href="{{ url('/products-sort',['parameter'=>'date','category'=>$categorySelected,'color'=>$colorSelected ]) }}">Sort by newness</a>
                            <a href="{{ url('/products-sort',['parameter'=>'low-to-high','category'=>$categorySelected,'color'=>$colorSelected ]) }}">Sort by price: low to high</a>
                            <a href="{{ url('/products-sort',['parameter'=>'high-to-low','category'=>$categorySelected,'color'=>$colorSelected ]) }}">Sort by price: high to low</a>
                        </div>
                    </div>

                    <!-- <div class="dropdown sort-item product-per-page">
                        @if(empty($pagination))
                        <div class="dropdown-container">9 per page &nbsp;<i class="fa fa-chevron-down"></i></div>
                        @else
                        <div class="dropdown-container">{{ $pagination }}&nbsp;<i class="fa fa-chevron-down"></i></div>
                        @endif
                        <div class="dropdown-content top">
                            <a href="https://blog.hubspot.com/">15 per page</a>
                            <a href="https://academy.hubspot.com/">21 per page</a>
                            <a href="https://www.youtube.com/user/hubspot">30 per page</a>
                        </div>
                    </div> -->

                    <div class="change-display-mode">
                        <a href="#" class="grid-mode display-mode active"><i class="fa fa-th"></i>Grid</a>
                    </div>

                </div>

            </div><!--end wrap shop control-->

            @if(Session::has('message'))
                <div style="height:10px;"></div>
                <div class="alert alert-success" role="alert"> {{Session::get('message')}} </div>
            @endif

            <div class="row">
                <ul class="product-list grid-products equal-container product-grid grid-3 main-products-container">

                @foreach ($products as $x => $product)
                    @if($product->quantity > 0)
                    <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                        <div class="border-style product">
                            <div class="product-thumnail" >

                                <div class="diy-slideshow slideshow_{{$x}}">
                                    @foreach($product->image as $i => $image)
                                        @if($i == 0)
                                        <figure class="show figure-product">
                                            <img style="min-height:100%" src="{{ $image }}" width="100%" />
                                        </figure>
                                        @else
                                        <figure class="figure-product">
                                            <img style="min-height:100%" src="{{ $image }}" width="100%" />
                                        </figure>
                                        @endif
                                    @endforeach
                                    @if(count($product->image) > 1)
                                        <a class="prev" onclick="prevImage('{{$x}}')">&laquo;</a>
                                        <a class="next" onclick="nextImage('{{$x}}')">&raquo;</a>
                                    @endif
                                </div>

                            </div>
                            <div class="product-info">
                                @if(isset($product->size_qty))
                                    @if($product->size_qty[0]->size !== $no_size)
                                    <span class="hovertext pull-right" style="white-space: pre-line;" data-hover="
                                                                        KIDS PONCHOS AND HOODIES:
                                                                        SIZE 0: New born - 1 year old
                                                                        SIZE 2: 1 year old - 2 years old
                                                                        SIZE 4: 2 years old - 4 years old
                                                                        SIZE 6: 4 years old - 6 years old

                                                                        KIDS OVERALLS AND DRESSES:
                                                                        SIZE 0: New born - 6 months
                                                                        SIZE 2: 6 months - 12 months
                                                                        SIZE 4: 1 year old - 2 years old
                                                                        SIZE 6: 2 years old - 3 years old
                                                                        "
                                                                         >
                                        Size guide <i class="fa fa-question-circle" style="margin-bottom: 12px; margin-right:5px;"></i> 
                                    </span>
                                    <a class="product-name" ><span class="center-span name-span"><b>{{$product->name}}</b></span></a>
                                    <div></div>
                                    <div style="text-align:center;">Size: </div>
                                    <div class="select">
                                        <select aria-label="Select menu example" id="size_select_{{$x}}">
                                            @foreach($product->size_qty as $size)
                                                @if($size->qty > 0)
                                                <option value="{{$size->size}}|{{$size->qty}}">{{$size->size}}</option>
                                                @else
                                                <option value="{{$size->size}}|{{$size->qty}}"> {{$size->size}} - out of stock</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="wrap-price" style="text-align:center;"><span style="color:#535555;font-weight:bold;">${{$product->regular_price}}</span></div>
                                    <a class="btn btn-success center-button" style="background-color:#222222;" onclick='addProductToCart("{{$product->id}}", "{{$page}}", "{{$x}}","")'>Add &nbsp<span class="fa fa-shopping-cart" style="color: white;"><span/></a>
                                    @else
                                    <a class="product-name"><span class="center-span name-span"><b>{{$product->name}}</b></span></a>
                                    <div class="wrap-price" style="text-align:center;"><span style="color:#535555;font-weight:bold;">${{$product->regular_price}}</span></div>
                                    <a class="btn btn-success center-button" style="background-color:#222222;" onclick='addProductToCart("{{$product->id}}", "{{$page}}",  "{{$no_size}}", "{{$product->quantity}}")'>Add &nbsp<span class="fa fa-shopping-cart" style="color: white;"><span/></a>
                                    @endif
                                @else
                                <span class="hovertext pull-left" data-hover="All of our bracelets are adjustable, so they can fit a kid or an adult.">
                                    <b>Size</b> <i class="fa fa-question-circle" style="margin-bottom: 12px; margin-right:5px;"></i> 
                                </span>
                                <a class="product-name"><span class="center-span name-span">{{$product->name}}</span></a>
                                <div class="wrap-price" style="text-align:center;"><span style="color:#535555;font-weight:bold;">${{$product->regular_price}}</span></div>
                                <a class="btn btn-success center-button" style="background-color:#222222;" onclick='addProductToCart("{{$product->id}}", "{{$page}}",  "{{$no_size}}" )'>Add &nbsp<span class="fa fa-shopping-cart" style="color: white;"><span/></a>
                                @endif
                            </div>
                        </div>
                    </li>
                    @endif
                @endforeach
                </ul>
            </div>

            <div class="wrap-pagination-info">
                {{$products->links()}}
            </div>
        </div><!--end main products area-->

    </div><!--end row-->

</div><!--end main area-->

<script>
    $(document).ready(function(){
        // $('html,body').animate({scrollTop: $("#productSection").offset().top}, 'fast');
    });    

    function addProductToCart(id,page,x,quantity_nosize){
        if(x !== "{{$no_size}}"){
            var size = $("#size_select_"+x).val().split("|")[0];
            var qty = $("#size_select_"+x).val().split("|")[1];
            
            if(qty > 0){
                window.location.href = "/product-add-cart/"+id+"/"+page+"/"+size+"/"+qty;
            }else{
                alert('There is no stock of this item');
            }
        }else{
            if(quantity_nosize > 0){
                window.location.href = "/product-add-cart/"+id+"/"+page+"/"+"{{$no_size}}"+"/"+quantity_nosize;
            }else{
                alert('There is no stock of this item');
            }
        }
    }
               
    $(document).on('change', '#orderby', function () {
        var order=$('#orderby').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/products-filter',
            type: 'POST',
            data: { orderby: order},
            success: function (data) {
                console.log('Success: ', data);
            },
            error: function (data) {
                console.log('Error: ', data);
            }
        });
    }); 

    var slideshows = [];

    function nextImage(x){
        var slideshow = getSlideshow(x);
        slideshow.counter++;
        showCurrent(slideshow); 
    }

    function prevImage(x){
        var slideshow = getSlideshow(x);
        slideshow.counter--;
        showCurrent(slideshow); 
    }

    // this function is what cycles the slides, showing the next or previous slide and hiding all the others
    var showCurrent = function(slideshow){
        var itemToShow = Math.abs(slideshow.counter%slideshow.numItems);// uses remainder (aka modulo) operator to get the actual index of the element to show  
        slideshow.items.removeClass('show'); // remove .show from whichever element currently has it
        slideshow.items.eq(itemToShow).addClass('show');    
    };

    function getSlideshow(x){
        if(slideshows[x] == null){ 
            
            var counter = 0, // to keep track of current slide
            $items = $('.slideshow_'+x+' figure'), // a collection of all of the slides, caching for performance
            numItems = $items.length; // total number of slides

            slideshows[x] = {
                'counter' : counter, 
                'items' : $items, 
                'numItems' : numItems
            };
            return slideshows[x];
        }
        else{
            return slideshows[x];
        }
        
    }

    function openMenu(x){
        if($('#sub-cate'+x).is(":visible")){
            $('#sub-cate'+x).hide();
        }
        else{
            $('#sub-cate'+x).show();
        }
    }

    // if touch events are supported then add swipe interactions using TouchSwipe https://github.com/mattbryson/TouchSwipe-Jquery-Plugin
    // if('ontouchstart' in window){
    //     $('.diy-slideshow').swipe({
    //         swipeLeft:function() {
    //         counter++;
    //         showCurrent(); 
    //         },
    //         swipeRight:function() {
    //         counter--;
    //         showCurrent(); 
    //         }
    //     });
    // }
</script>
@endsection

