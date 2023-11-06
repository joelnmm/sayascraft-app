@extends('layouts.mail-base')
@section('content')
<div style="display: inline-block;">
    <div style="text-align:left;">
        <p>Hi {{$order->firstname}} {{$order->lastname}},</p>
        <p>Thank you for shopping at Saya's Craft, your order has been successfully placed on {{$order->created_at}}</p>
        <p>You'll receive another email with the tracking number of your package once we ship your order.
            <br> We usually ship within the next bussiness day.
            <br> You can also keep track of your package on the user dashboard if you have a Saya's Craft account.
        </p>
        <p>Your order number is: {{$order->order_number}}</p>
        <p>TRANSACTION_ID: {{$order->transaction_id}}</p>
        <p>AUTHORIZATION_CODE: {{$order->authorization_code}}</p>
        <br>
    </div>

    <h2 style="text-align:left;">Shipping Details</h2>
    <table style="width: 600px; text-align:right; margin-bottom:40px; border-bottom:1px solid #ccc;">
            <tr>
                <th>Name</th>
                <td>{{ $shipping->firstname }} {{ $shipping->lastname }}</td>
                <th>Mobile</th>
                <td>{{ $shipping->mobile }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $shipping->email }}</td>
                <th>Address</th>
                <td>{{ $shipping->line1 }}</td>
            </tr>
            <tr>
                <th>City</th>
                <td>{{ $shipping->city }}</td>
                <th>State</th>
                <td>{{ $shipping->province }}</td>
            </tr>
            <tr>      
                <th>Zipcode</th>
                <td>{{ $shipping->zipcode }}</td>
                <th>Counrty</th>
                <td>{{ $shipping->country }}</td>
            </tr>
    </table>
    
    <h2 style="text-align:left;">Order Details</h2>
    <table style="width: 600px; text-align:right;">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->OrderItems as $item)
            <tr>
                <td><img src="{{ asset($item->image) }}" width="100"/></td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="border-top:1px solid #ccc;"></td>
                <td style="font-size:15px; font-weight:bold; border-top:1px solid #ccc;">Subtotal: {{ $order->subtotal }}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="font-size:15px; font-weight:bold;">Shipping: $3.00</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="font-size:15px; font-weight:bold;">Tax: {{ $order->tax }}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="font-size:15px; font-weight:bold;">Total: {{ $order->total }}</td>
            </tr>
        </tbody>

    </table>
</div>

@endsection
