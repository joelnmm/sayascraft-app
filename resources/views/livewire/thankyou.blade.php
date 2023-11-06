@extends('layouts.base')
@section('content')
<div>
    <!--main area-->
	<main id="main" class="main-site">
        <div class="container">

            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="/" class="link">home</a></li>
                    <li class="item-link"><span>Thank You</span></li>
                </ul>
            </div>
        </div>

        <div class="container pb-60">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Thank you for your order</h2>
                    <div style="height:10px;"></div>
                    <p>Your order number is: {{ session()->get('order_number') }}</p>
                    <p>Authorization code: {{ session()->get('authorization_code') }}</p>
                    <p>Transaction Id: {{ session()->get('transaction_id') }}</p>
                    <p>A confirmation email was sent to {{ session()->get('email') }}</p>
                    <div style="height:20px;"></div>
                    <a href="/products" class="btn btn-submit btn-submitx" style="background-color:black;">Continue Shopping</a>
                </div>
            </div>
        </div><!--end container-->
    </main>
    <!--main area-->
</div>
@endsection
