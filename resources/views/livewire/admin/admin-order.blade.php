@extends('layouts.admin-base')
@section('content')
<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        border-radius: 3px;
        padding: 5px 5px;
        z-index: 1;
        width: 110px;
    }
    .dropdown:hover .dropdown-content {
        display: block;
    }
    .dropdown:hover .dropdown-content a{
        color:#212121;
        margin-bottom:5px;
    }
    .dropdown:hover .dropdown-content a:hover{
        color: darkcyan;
    }
    .dialog {
        block-size: fit-content;
        color-scheme: #f5f5f5;
        border: none;
        border-radius: 5px;
    }
    .body-dialog {
        min-block-size: 100%;
        font-family: system-ui, sans-serif;
        
        display: grid;
        place-content: center;
        margin: 0;
    }
</style>
<head>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>
<div class="container-xl">
    <div class="table-responsive">
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
                @if(Session::has('order_message'))
                    <div class="alert alert-success" role="alert"> {{Session::get('order_message')}} </div>
                @endif
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>OrderId<i class="fa fa-sort"></i></th>
                            <th>Order Number</i></th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Total</th>
                            <th>Name </th>
                            <th>Last Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Tracking Number</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th colspan="2" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$order->id}}</td>
                                <td>{{$order->order_number}}</td>
                                <td>{{$order->subtotal}}</td>
                                <td>{{$order->discount}}</td>
                                <td>{{$order->tax}}</td>
                                <td>{{$order->total}}</td>
                                <td>{{$order->firstname}}</td>
                                <td>{{$order->lastname}}</td>
                                <td>{{$order->mobile}}</td>
                                <td>{{$order->email}}</td>
                                @if($order->tracking_number != null)
                                <td>Provided</td>
                                @else
                                <td>Not provided</td>
                                @endif
                                <td>{{$order->status}}</td>
                                <td>{{$order->created_at}}</td>
                                <td style="width: 180px;">
                                    <a href="{{ url('/admin/order-details', ['id'=> $order->id]) }}" class="btn btn-success btn-sm" title="View" data-toggle="tooltip" style="background-color:#212121; border-color:#212121; color:white; ">Details</a>
                                    <div class="dropdown" style="margin-top: 5px;">
                                        <button class="btn btn-success btn-sm dropdown-toggle" style="width: 105%;">Action &nbsp</span></button>
                                        <div class="dropdown-content">
                                            <a href="{{ url('/admin/order-update-status', ['id'=> $order->id, 'status'=> 'delivered']) }}">Delivered</a>
                                            <a href="{{ url('/admin/order-update-status', ['id'=> $order->id, 'status'=> 'canceled']) }}">Canceled</a>
                                            <a href="#" onclick='dialog.showModal(); getId("{{$order->id}}");'>Add tracking</a>
                                            @if($order->tracking_number != null)
                                            <a href="{{ url('/admin/send-tracking-mail', ['id'=> $order->id]) }}">Send tracking num. mail</a>
                                            @endif
                                        </div>
                                    </div>
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
    </div>
</div>
<dialog id="dialog" class="dialog">
  <form action="{{url('admin/add-tracking')}}" method="POST" class="body-dialog dialog">
  @csrf
    <input type="text" name="id" id="id" style="display:none;"/>
    <div class="formbold-mb-5">
        <label for="shipping_company" class="formbold-form-label"><b>Shipping Company:</b> </label>
        <input type="text" name="shipping_company" id="shipping_company" placeholder="Shipping company" class="formbold-form-input" required/>
    </div>
    <div class="formbold-mb-5">
        <label for="tracking_number" class="formbold-form-label"><b>Tracking Number:</b> </label>
        <input type="text" name="tracking_number" id="tracking_number" placeholder="Tracking number" class="formbold-form-input" required/>
    </div>
    <p class="row-in-form fill-wife">
        <label class="checkbox-field">
            <input name="send_mail" value=1 type="checkbox">
            <span style="color:black">Send Tracking Number email?</span>
        </label>
    </p>
    <button class="btn btn-success" style="background-color:#312e2e; border:#312e2e; margin: 10px 0 10px 0;" onclick="dialog.close()">Cancel</button>
    <button class="btn btn-success" type="submit" value="confirm">Add</button>
  </form>
</dialog>

<script>
    $(document).on('keypress',function(e) {
        var query = $('#search').val();
        if(e.which == 13 && query !== '') {
            if(query.includes("/")){
                query = query.replace("/","||")
            }
            window.location.href = "/admin/search-order/"+query
        }
    });
    function getId(id){
        $('#id').val(id);
    }
</script>
@endsection