@extends('layouts.mail-base')
@section('content')
<div style="display: inline-block;">
    <div style="text-align:left;">
        <p>Hi {{$order->firstname}} {{$order->lastname}},</p>
        <p>Thank you for shopping at Saya's Craft, the tracking number for your order No. {{$order->order_number}} has been provided.</p>
        
        <h3 style="text-align:left;">Tracking Details</h3>
        <p><b>Shipping Company:</b> {{$order->shipping_company}}</p>
        <p><b>Tracking Number:</b> {{$order->tracking_number}}</p>
        <p>You can also check your tracking details on your Saya's Craft account in Dashboard > My orders > Details</p>
        <br>
        <br>
        <p>Regards,</p>
        <p>Saya's Craft</p>
    </div>
</div>
@endsection
