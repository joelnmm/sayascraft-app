@extends('layouts.admin-base')
@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Products <b>Details</b></h2></div>
                        <div style="height: 10px;"></div>
                        <div class="col-sm-8">
                            <a href="{{ route('admin.products.create')}}" class="btn btn-success">Add New Product</a>
                        </div>
                        <div class="col-sm-4">
                            <div class="search-box">
                                <i class="material-icons">&#xE8B6;</i>
                                <input id="search" type="text" class="form-control" placeholder="Search&hellip;">
                            </div>
                        </div>
                    </div>
                </div>
                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert"> {{Session::get('message')}} </div>
                @endif
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Id<i class="fa fa-sort"></i></th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Short Description</th>
                            <th>Description</th>
                            <th>Stock </th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>Quantity </i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$product->id}}</td>
                                <td><img src="{{$product->image[0]}}" width="120"></td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->short_description}}</td>
                                <td>{{$product->description}}</td>
                                <td>{{$product->stock_status}}</td>
                                <td>{{$product->regular_price}}</td>
                                <td>{{$product->sale_price}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>
                                    <a href="#" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                                    <a href="{{ url('/admin/edit-product', ['id'=> $product->id]) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                    <a href="{{ url('/admin/destroy-product', ['id'=> $product->id]) }}" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix st">
                    {{$products->links()}}
                    <!-- <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                    <ul class="pagination">
                        <li class="page-item disabled"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item active"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">4</a></li>
                        <li class="page-item"><a href="#" class="page-link">5</a></li>
                        <li class="page-item"><a href="#" class="page-link"><i class="fa fa-angle-double-right"></i></a></li>
                    </ul> -->
                </div>
            </div>
        </div>  
    </div>
</div>
<script>
     $(document).on('keypress',function(e) {
        var query = $('#search').val();
        if(e.which == 13 && query !== '') {
            if(query.includes("/")){
                query = query.replace("/","||")
            }
            window.location.href = "/admin/search-product/"+query
        }
    });
</script>
@endsection

