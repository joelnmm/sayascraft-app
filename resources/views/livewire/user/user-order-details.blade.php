@extends('layouts.user-base')
@section('content')
<style>
    @media (max-width: 800px) { 
        .desktop-header{
            display: none;
        }
    }

    @media (max-width: 500px) { 
        .desktop-table{
            display: none;
        }
        .mobile-table{
            display: block;
        }
    }

    @media (min-width: 500px) { 
        .desktop-table{
            display: block;
        }
        .mobile-table{
            display: none;
        }
    }

</style>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-responsive">
            <div class="table-wrapper">
                @if(Session::has('order_message'))
                    <div class="alert alert-success" role="alert"> {{Session::get('order_message')}} </div>
                @endif
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Order <b>Details</b></h2></div>
                        <div class="col-sm-4">
                            <a href="{{ route('user.orders')}}" class="btn btn-success pull-right">My Orders</a>
                            @if($order->status == 'ordered')
                            <!-- <a onclick='confirmOrderCancel("{{$order->id}}")' class="btn btn-warning">Cancel Order</a> -->
                            @endif
                        </div>
                    </div>
                    <div class="panel-body desktop-table">
                        <table class="table" style="border-top: solid; margin-top:30px">
                            <tr>
                                <th>Order Id</th>
                                <td>{{$order->id}}</td>
                                <th>Order Date</th>
                                <td>{{$order->created_at}}</td>
                                <th>Status</th>
                                <td>{{$order->status}}</td>
                                @if($order->status == 'delivered')
                                <th>Delivery Date</th>
                                <td>{{$order->delivered_date}}</td>
                                @elseif($order->status == 'canceled')
                                <th>Cancellation Date</th>
                                <td>{{$order->canceled_date}}</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                    <div class="panel-body mobile-table">
                        <table class="table" style="border-top: solid; margin-top:30px">
                            <tr>
                                <th>Order Id</th>                                
                                <th>Order Date</th>                           
                                <th>Status</th>
                                @if($order->status == 'delivered')
                                <th>Delivery Date</th>
                                @elseif($order->status == 'canceled')
                                <th>Cancellation Date</th>
                                @endif
                            </tr>
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->status}}</td>
                                @if($order->status == 'delivered')
                                <td>{{$order->delivered_date}}</td> 
                                @elseif($order->status == 'canceled')
                                <td>{{$order->canceled_date}}</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                    <div class="desktop-table">
                        <table class="table" style="margin-top:-15px">
                            <tr>
                                <th>Shipping company:</th>
                                @if($order->shipping_company != null)
                                <td>{{$order->shipping_company}}</td>
                                @else
                                <td>Not provided yet</td>
                                @endif
                                <th>Tracking Number:</th>
                                @if($order->tracking_number != null)
                                <td>{{$order->tracking_number}}</td>
                                @else
                                <td>Not provided yet</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                    <div class="desktop-table mobile-table">
                        <table class="table" style="margin-top:-15px">
                            <tr>
                                <th>Shipping company:</th>
                                @if($order->shipping_company != null)
                                <td>{{$order->shipping_company}}</td>
                                @else
                                <td>Not provided yet</td>
                                @endif
                            </tr>
                            <tr>
                                <th>Tracking Number:</th>
                                @if($order->tracking_number != null)
                                <td>{{$order->tracking_number}}</td>
                                @else
                                <td>Not provided yet</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Order <b>Items</b></h2></div>
                    </div>
                </div>
                
                <div class="wrap-iten-in-cart">                    
                    <ul class="products-cart desktop-header" style="margin-bottom:-15px">
                        <li class="pr-cart-item">
                            <div class="product-image"></div>
                            <div class="product-name">
                                <h3 class="box-title">Name</h3>
                            </div>
                            <div class="price-field produtc-price">
                                <h3 class="box-title" style="margin-left:70px;">Price</h3>
                            </div>
                            <div class="quantity">
                                <h3 class="box-title">Quanity</h3>
                            </div>
                            <div class="price-field sub-total">
                                <h3 class="box-title" style="margin-left:50px;">Subtotal</h3>
                            </div>
                        </li>
                    </ul>

                    <ul class="products-cart">
                        @foreach ($order->OrderItems as $item)
                        <li class="pr-cart-item">
                            <div class="product-image">
                                <figure><img src="{{$item->image}}" alt="{{$item->image}}"></figure>
                            </div>
                            <div class="product-name">
                                <a class="link-to-product" href="#">{{$item->product_name}}</a>
                            </div>
                            <div class="price-field produtc-price"><p class="price">${{$item->price}}</p></div>
                            <div class="quantity">
                                <h5>{{$item->quantity}}</h5>
                            </div>
                            <div class="price-field sub-total"><p class="price">${{$item->price * $item->quantity}}</p></div>
                            
                        </li>
                        @endforeach				
                    </ul>
                </div>

                <div class="summary">
                    <div class="order-summary">
                        <h4 class="title-box">Order Summary</h4>
                        <p class="summary-info"><span class="title">Subtotal</span><b class="index">${{$order->subtotal}}</b></p>
                        <p class="summary-info"><span class="title">Shipping</span><b class="index">$3.00</b></p>
                        <p class="summary-info"><span class="title">Tax</span><b class="index">${{$order->tax}}</b></p>
                        <p class="summary-info"><span class="title">Total</span><b class="index">${{$order->total}}</b></p>
                    </div>
                </div>

            </div>
        </div>  
    </div>
</div>

<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Billing <b>Details</b></h2></div>
                </div>
            </div>

            <div class="panel-body desktop-table">
                <table class="table">
                    <tr>
                        <th>First Name</th>
                        <td>{{$order->firstname}}</td>
                        <th>Last Name</th>
                        <td>{{$order->lastname}}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{$order->mobile}}</td>
                        <th>Email</th>
                        <td>{{$order->email}}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{$order->line1}}</td>
                        <th>Address line2</th>
                        <td>{{$order->line2}}</td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td>{{$order->city}}</td>
                        <th>State</th>
                        <td>{{$order->province}}</td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td>{{$order->country}}</td>
                        <th>Zipcode</th>
                        <td>{{$order->zipcode}}</td>
                    </tr>
                </table>
            </div>
            <div class="panel-body mobile-table">
                <table class="table">
                    <tr>
                        <th>First Name</th>
                        <td>{{$order->firstname}}</td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>{{$order->lastname}}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{$order->mobile}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$order->email}}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{$order->line1}}</td>
                    </tr>
                    <tr>
                        <th>Address line2</th>
                        <td>{{$order->line2}}</td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td>{{$order->city}}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>{{$order->province}}</td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td>{{$order->country}}</td>
                    </tr>
                    <tr>
                        <th>Zipcode</th>
                        <td>{{$order->zipcode}}</td>
                    </tr>
                </table>
            </div>
            
        </div>
    </div>
</div>

@if($order->is_shipping_different)
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Shipping <b>Details</b></h2></div>
                    </div>
                </div>
                <div class="panel-body desktop-table">
                    <table class="table">
                        <tr>
                            <th>First Name</th>
                            <td>{{$order->shipping->firstname}}</td>
                            <th>Last Name</th>
                            <td>{{$order->shipping->lastname}}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{$order->shipping->mobile}}</td>
                            <th>Email</th>
                            <td>{{$order-shipping->email}}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{$order->shipping->line1}}</td>
                            <th>Address line2</th>
                            <td>{{$order->shipping->line2}}</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>{{$order->shipping->city}}</td>
                            <th>State</th>
                            <td>{{$order->shipping->province}}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{$order->shipping->country}}</td>
                            <th>Zipcode</th>
                            <td>{{$order->shipping->zipcode}}</td>
                        </tr>
                    </table>
                </div>

                <div class="panel-body mobile-table">
                    <table class="table">
                        <tr>
                            <th>First Name</th>
                            <td>{{$order->shipping->firstname}}</td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>{{$order->shipping->lastname}}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{$order->shipping->mobile}}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{$order-shipping->email}}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{$order->shipping->line1}}</td>
                        </tr>
                        <tr>
                            <th>Address line2</th>
                            <td>{{$order->shipping->line2}}</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>{{$order->shipping->city}}</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>{{$order->shipping->province}}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{$order->shipping->country}}</td>
                        </tr>
                        <tr>
                            <th>Zipcode</th>
                            <td>{{$order->shipping->zipcode}}</td>
                        </tr>
                    </table>
                </div>
        
            </div>
        </div>  
    </div>
</div>
@else
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Shipping <b>Details</b></h2></div>
                    </div>
                </div>
                <h3 style="text-align:center;">Billing address is same as shipping address</h4>
            </div>
        </div>  
    </div>
</div>
@endif

<div class="container-xl">
    <div class="table-responsive">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Transaction <b>Details</b></h2></div>
                    </div>
                </div>

                <table class="table">
                    <tr>
                        <th>Transaction Mode</th>
                        <td>{{$order->transaction->mode}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{$order->transaction->status}}</td>
                    </tr>
                    <tr>
                        <th>Transaction Date</th>
                        <td>{{$order->transaction->created_at}}</td>
                    </tr>
                </table>
            </div>
        </div>  
    </div>
</div>
<script>
    function confirmOrderCancel(id){
        if (confirm("Are you sure you want to cancel this order?")) {
            window.location.href = "/user/cancel-order/"+id
        } 
    }
</script>
@endsection