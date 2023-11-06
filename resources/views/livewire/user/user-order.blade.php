@extends('layouts.user-base')
@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>
    <style>
        @media (max-width: 500px) { 
            .table-wrapper{
                padding: 10px;
            }
        }
    </style>
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Orders <b>Details</b></h2></div>
                    <div class="col-sm-12">
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
            <table class="table table-striped table-hover table-bordered desktop-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Number<i class="fa fa-sort"></i></th>
                        <th>Subtotal</th>
                        <th>Discount</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th>Name </th>
                        <th>Last Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Zipcode</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$order->order_number}}</td>
                            <td>{{$order->subtotal}}</td>
                            <td>{{$order->discount}}</td>
                            <td>{{$order->tax}}</td>
                            <td>{{$order->total}}</td>
                            <td>{{$order->firstname}}</td>
                            <td>{{$order->lastname}}</td>
                            <td>{{$order->mobile}}</td>
                            <td>{{$order->email}}</td>
                            <td>{{$order->zipcode}}</td>
                            <td>{{$order->status}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>
                                <a href="{{ url('/user/order-details', ['id'=> $order->id]) }}" class="btn btn-success" title="View" data-toggle="tooltip">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table table-striped table-hover table-bordered tablet-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Number<i class="fa fa-sort"></i></th>
                        <th>Discount</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th>Name </th>
                        <th>Last Name</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$order->order_number}}</td>
                            <td>{{$order->discount}}</td>
                            <td>{{$order->tax}}</td>
                            <td>{{$order->total}}</td>
                            <td>{{$order->firstname}}</td>
                            <td>{{$order->lastname}}</td>
                            <td>{{$order->status}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>
                                <a href="{{ url('/user/order-details', ['id'=> $order->id]) }}" class="btn btn-success" title="View" data-toggle="tooltip">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table table-striped table-hover table-bordered mobile-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Number<i class="fa fa-sort"></i></th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$order->order_number}}</td>
                            <td>{{$order->total}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>
                                <a href="{{ url('/user/order-details', ['id'=> $order->id]) }}" class="btn btn-success" title="View" data-toggle="tooltip">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="clearfix st">
                {{$orders->links()}}
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
            window.location.href = "/user/search-order/"+query
        }
    });
</script>
@endsection