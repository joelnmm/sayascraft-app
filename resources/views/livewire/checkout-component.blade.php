@extends('layouts.base')
@section('content')
<!--main area-->
<head>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.paymentez.com/ccapi/sdk/payment_checkout_3.0.0.min.js"></script>
</head>

<div class="container">

    <div class="wrap-breadcrumb">
        <ul>
            <li class="item-link"><a href="/" class="link">home</a></li>
            <li class="item-link"><span>checkout</span></li>
        </ul>
    </div>
    <div class=" main-content-area">
        <form id="form" method="POST" action="{{url('place-order-paymentez')}}" enctype="multipart/form-data" onsubmit="$('#processing').show();">
        @csrf
            <div class="row">
                <!-- Billing section -->
                <div class="col-md-12">
                    <div class="wrap-address-billing">
                        <h3 class="box-title">Billing Address</h3>
                        <div class="billing-address">

                            <p class="row-in-form">
                                <label for="fname">first name<span>@error('firstname')*@enderror</span></label>
                                <input type="text" id="firstname" name="firstname" value="{{old('firstname', '')}}" placeholder="Your name" required>
                                @error('firstname')
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="lname">last name<span>@error('lastname')*@enderror</span></label>
                                <input type="text" id="lastname" name="lastname" value="{{old('lastname', '')}}" placeholder="Your last name" required>
                                @error('lastname')
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="email">Email Addreess:<span>@error('email')*@enderror</span></label>
                                <input type="email" id="email" name="email" value="{{old('email', '')}}" placeholder="Type your email" required>
                                @error('email')
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="phone">Phone number<span>@error('mobile')*@enderror</span></label>
                                <input type="number" id="mobile" name="mobile" value="{{old('mobile', '')}}" placeholder="10 digits format" required>
                                @error('mobile')
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="add">Address:<span>@error('address')*@enderror</span></label>
                                <input type="text" id="address" name="address" value="{{old('address', '')}}" placeholder="Street at apartment number" required>
                                @error('address')
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="country">Country<span>@error('country')*@enderror</span></label>
                                <input type="text" id="country" name="country" value="{{old('country', '')}}" placeholder="United States" required>
                                @error('country')
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="zip-code">ZIP Code:<span>@error('zipcode')*@enderror</span></label>
                                <input type="text" id="zipcode" name="zipcode" value="{{old('zipcode', '')}}" placeholder="Your postal code" required>
                                @error('zipcode')
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="state">State / Province<span>@error('state')*@enderror</span></label>
                                <input type="text" id="state" name="state" value="{{old('state', '')}}" placeholder="State / Province" required>
                                @error('state')
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="city">Town / City<span>@error('city')*@enderror</span></label>
                                <input type="text" id="city" name="city" value="{{old('city', '')}}" placeholder="City name" required>
                                @error('city')
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form fill-wife">
                                <label class="checkbox-field">
                                    <input type="checkbox" name="different-add" id="different-add" >
                                    <span>Ship to a different address?</span>
                                    <input type="text" id="ship_to_different" name="ship_to_different" value=0 style="display:none;" required>
                                </label>
                            </p>

                            @if(Session::has('guest_checkout'))
                                <p class="row-in-form"><input type="text" name="guest_checkout" value=1 style="display:none;"></p> 
                                {{ session()->put('guest_checkout',true) }}
                            @endif

                            <input type="text" id="paymentez_response" name="paymentez_response" style="display:none;">
                        </div>
                    </div>
                </div>

                <!-- Shipping section -->
                <div class="col-md-12" id="shipping_section" style="display:none;">
                    <div class="wrap-address-billing">
                        <h3 class="box-title">Shipping Address</h3>
                        <div class="billing-address">
                            <p class="row-in-form">
                                <label for="fname">first name<span>@error('shipping_firstname')*@enderror</span></label>
                                <input type="text" id="shipping_firstname" name="shipping_firstname" value="{{old('shipping_firstname', '')}}" placeholder="Your name">
                                @error('shipping_firstname')
                                    <script>$('#shipping_section').show(); $("#different-add").prop("checked", true);</script>
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="lname">last name<span>@error('shipping_lastname')*@enderror</span></label>
                                <input type="text" id="shipping_lastname" name="shipping_lastname" value="{{old('shipping_lastname', '')}}" placeholder="Your last name">
                                @error('shipping_lastname')
                                    <script>$('#shipping_section').show(); $("#different-add").prop("checked", true);</script>
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="email">Email Addreess:<span>@error('shipping_email')*@enderror</span></label>
                                <input type="email" id="shipping_email" name="shipping_email" value="{{old('shipping_email', '')}}" placeholder="Type your email">
                                @error('shipping_email')
                                    <script>$('#shipping_section').show(); $("#different-add").prop("checked", true);</script>
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="mobile">Phone number<span>@error('shipping_mobile')*@enderror</span></label>
                                <input type="number" id="shipping_mobile" name="shipping_mobile" value="{{old('shipping_mobile', '')}}" placeholder="10 digits format">
                                @error('shipping_mobile')
                                    <script>$('#shipping_section').show(); $("#different-add").prop("checked", true);</script>
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="add">Address:<span>@error('shipping_address')*@enderror</span></label>
                                <input type="text" id="shipping_address" name="shipping_address" value="{{old('shipping_address', '')}}" placeholder="Street at apartment number">
                                @error('shipping_address')
                                    <script>$('#shipping_section').show(); $("#different-add").prop("checked", true);</script>
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="country">Country:<span>@error('shipping_country')*@enderror</span></label>
                                <input type="text" id="shipping_country" name="shipping_country" value="{{old('shipping_country', '')}}" placeholder="United States">
                                @error('shipping_country')
                                    <script>$('#shipping_section').show(); $("#different-add").prop("checked", true);</script>
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="zip-code">ZIP Code:<span>@error('shipping_zipcode')*@enderror</span></label>
                                <input type="text" id="shipping_zipcode" name="shipping_zipcode" value="{{old('shipping_zipcode', '')}}" placeholder="Your postal code">
                                @error('shipping_zipcode')
                                    <script>$('#shipping_section').show(); $("#different-add").prop("checked", true);</script>
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="state">State / Province:<span>@error('shipping_state')*@enderror</span></label>
                                <input type="text" id="shipping_state" name="shipping_state" value="{{old('shipping_state', '')}}" placeholder="State / Province">
                                @error('shipping_state')
                                    <script>$('#shipping_section').show(); $("#different-add").prop("checked", true);</script>
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="city">Town / City:<span>@error('shipping_city')*@enderror</span></label>
                                <input type="text" id="shipping_city" name="shipping_city" value="{{old('shipping_city', '')}}" placeholder="City name">
                                @error('shipping_city')
                                    <script>$('#shipping_section').show(); $("#different-add").prop("checked", true);</script>
                                    <a style="color:red;">{{ $message }}</a>
                                @enderror
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            
            <!-- Summary checkout -->
            <div class="summary summary-checkout">
                <div class="summary-item payment-method">
                    <h4 class="title-box">Payment Section</h4>
                    <!-- <div class="choose-payment-methods" style="border: none; margin-top:-10px">
                        @if(Session::has('stripe_error'))
                         <div class="alert alert-danger" role="alert">{{Session::get('stripe_error')}}</div>
                        @endif
                        <p class="row-in-form fill-wife">
                            <label class="checkbox-field" >
                                <input name="payment_method" id="payment-method-card" value="card" type="checkbox">
                                <span style="color:black">Credit/Debit Card </span>
                                <img src="/assets/img/cards/cards.png" >
                            </label>

                            <div class="wrap-address-billing" id="card_data" style="display:none; margin-top:20px;">
                                <p class="row-in-form" >
                                    <label for="card_holder">Card Holder Name:<span>@error('card_holder')*@enderror</span></label>
                                    <input type="text" name="card_holder" value="{{old('card_holder', '')}}" placeholder="Card Holder Name">
                                    @error('card_holder')
                                        <script>$('#card_data').show(); $("#payment-method-card").prop("checked", true);</script>
                                        <a style="color:red;">{{ $message }}</a>
                                    @enderror
                                </p>
                                <p class="row-in-form" >
                                    <label for="card_number">Card Number:<span>@error('card_number')*@enderror</span></label>
                                    <input type="number" name="card_number" value="{{old('card_number', '')}}" placeholder="Card Number">
                                    @error('card_number')
                                        <script>$('#card_data').show(); $("#payment-method-card").prop("checked", true);</script>
                                        <a style="color:red;">{{ $message }}</a>
                                    @enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="exp_date">Expiration Date:<span>@error('exp_date')*@enderror</span></label>
                                    <input type="text" oninput="maxLengthCheck(this)" max="5" name="exp_date" placeholder="MM/YY" value="{{old('exp_date', '')}}">
                                    @error('exp_date')
                                        <script>$('#card_data').show(); $("#payment-method-card").prop("checked", true);</script>
                                        <a style="color:red;">{{ $message }}</a>
                                    @enderror
                                </p>
                                <p class="row-in-form" style="width: 25%;">
                                    <label for="cvc_code">CVC:<span>@error('cvc_code')*@enderror</span></label>
                                    <input class="inputDesign" type="password" oninput="maxLengthCheck(this)" max="4" name="cvc_code" value="{{old('cvc_code', '')}}" placeholder="CVC">
                                    @error('cvc_code')
                                        <script>$('#card_data').show(); $("#payment-method-card").prop("checked", true);</script>
                                        <a style="color:red;">{{ $message }}</a>
                                    @enderror
                                </p>
                            </div>
                        </p>

                        <p class="row-in-form fill-wife">
                            <label class="checkbox-field" >
                                <input name="payment_method" id="payment-method-card" value="card" type="checkbox">
                                <span style="color:black">Credit/Debit Card </span>
                                <img src="/assets/img/cards/cards.png" >
                            </label>
                        </p>

                        <p class="row-in-form fill-wife">
                            <label class="checkbox-field">
                                <input name="payment_method" id="payment-method-paypal" value="paypal" type="checkbox">
                                <span style="color:black">Paypal</span>
                            </label>
                        </p>
                        @error('payment_method')
                            <a style="color:red;">{{ $message }}</a>
                        @enderror
                    </div> -->

                    @if(Session::has('checkout'))
                        <p class="summary-info grand-total"><span>Grand Total</span> <span class="grand-total-price">${{Session::get('checkout')['total']}}</span></p>
                    @endif

                    <!-- <div id="response"></div> -->

                    <div style="margin-bottom: 10px;">
                        <!-- <p class="row-in-form fill-wife"> -->
                            <label class="checkbox-field">
                                <input id="terms_conditions" name="terms_conditions" value=1 type="checkbox" required>
                                <span style="color:black">I accept <a href="/terms-and-conditions" target="_blank">Terms and Conditions</a></span>
                            </label>
                        <!-- </p> -->
                        @error('terms_conditions')
                            <a style="color:red;">{{ $message }}</a>
                        @enderror
                    </div>

                    @if($errors->isEmpty() && !Session::has('stripe_error'))
                    <div wire:ignore id="processing" style="font-size:22px; margin-bottom:20px; padding-left:37px; color:green; display:none;">
                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                        <span>Processing...</span>
                    </div>
                    @endif
                    <a id="submit" class="btn btn-medium" style="background-color:black;" onclick="validateFields()">Place order now & Pay</a>
                </div>
                <div class="summary-item shipping-method">
                    <h4 class="title-box f-title">Shipping method</h4>
                    <p class="summary-info"><span class="title">Flat Rate</span></p>
                    <p class="summary-info"><span class="title">${{number_format(Session::get('checkout')['shipping'],2)}}</span></p>
                </div>
            </div>
        </form>

    </div><!--end main content area-->
</div><!--end container-->

<script>
    $("input[id=payment-method-card").change(function(){
        if ($("#payment-method-card").is(":checked")) {
            $('#card_data').show();

            $('#payment-method-paypal').prop('checked', false);

        }
        else {
            $('#card_data').hide();
        }
    });

    $("input[id=payment-method-paypal").change(function(){
        if ($("#payment-method-paypal").is(":checked")) {
            
            $('#payment-method-card').prop('checked', false);
            $('#card_data').hide();
            $('#is_card').val(0);
        }
        else {
        }
    });

    $("input[name=different-add").change(function(){
        if ($("#different-add").is(":checked")) {
            $('#shipping_section').show();
            $('#ship_to_different').val(1);

            $("#shipping_firstname").prop('required',true);
            $("#shipping_lastname").prop('required',true);
            $("#shipping_email").prop('required',true);
            $("#shipping_mobile").prop('required',true);
            $("#shipping_address").prop('required',true);
            $("#shipping_country").prop('required',true);
            $("#shipping_zipcode").prop('required',true);
            $("#shipping_state").prop('required',true);
            $("#shipping_city").prop('required',true);
        }
        else {
            $('#shipping_section').hide();
            $('#ship_to_different').val(0);

            $("#shipping_firstname").removeAttr('required');
            $("#shipping_lastname").removeAttr('required');
            $("#shipping_email").removeAttr('required');
            $("#shipping_mobile").removeAttr('required');
            $("#shipping_address").removeAttr('required');
            $("#shipping_country").removeAttr('required');
            $("#shipping_zipcode").removeAttr('required');
            $("#shipping_state").removeAttr('required');
            $("#shipping_city").removeAttr('required');
        }
    });

    function maxLengthCheck(object)
    {
        if (object.value.length > object.max){
            object.value = object.value.slice(0, object.max);
        }

        $("input[name=exp_date").on('keyup', function(e) {
            if(object.value.length == 2 && e.which !== 8){
                if(!object.value.includes('/')){
                    object.value = object.value + '/';
                }
            }
        });
    }

    function validateFields()
    {
        var validations = [];
        console.log('validando...')

        if ($("#different-add").is(":checked")) 
        {
            validations.push(document.getElementById('firstname').reportValidity());
            validations.push(document.getElementById('lastname').reportValidity());
            validations.push(document.getElementById('email').reportValidity());
            validations.push(document.getElementById('mobile').reportValidity());
            validations.push(document.getElementById('address').reportValidity());
            validations.push(document.getElementById('country').reportValidity());
            validations.push(document.getElementById('zipcode').reportValidity());
            validations.push(document.getElementById('state').reportValidity());
            validations.push(document.getElementById('city').reportValidity());
            validations.push(document.getElementById('terms_conditions').reportValidity());

            validations.push(document.getElementById('shipping_firstname').reportValidity());
            validations.push(document.getElementById('shipping_lastname').reportValidity());
            validations.push(document.getElementById('shipping_email').reportValidity());
            validations.push(document.getElementById('shipping_mobile').reportValidity());
            validations.push(document.getElementById('shipping_address').reportValidity());
            validations.push(document.getElementById('shipping_country').reportValidity());
            validations.push(document.getElementById('shipping_zipcode').reportValidity());
            validations.push(document.getElementById('shipping_state').reportValidity());
            validations.push(document.getElementById('shipping_city').reportValidity());
        }
        else
        {
            validations.push(document.getElementById('firstname').reportValidity());
            validations.push(document.getElementById('lastname').reportValidity());
            validations.push(document.getElementById('email').reportValidity());
            validations.push(document.getElementById('mobile').reportValidity());
            validations.push(document.getElementById('address').reportValidity());
            validations.push(document.getElementById('country').reportValidity());
            validations.push(document.getElementById('zipcode').reportValidity());
            validations.push(document.getElementById('state').reportValidity());
            validations.push(document.getElementById('city').reportValidity());
            validations.push(document.getElementById('terms_conditions').reportValidity());
        }

        if(!validations.includes(false))
        {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: '/generate-reference/' + $('#firstname').val() + ' ' + $('#lastname').val() +'/' + $('#email').val(),
                success: function (data) {
                    let object  = JSON.stringify(data);
                    let response = JSON.parse(object);
                    var reference = response.reference;
                    
                    paymentCheckout.open({
                        reference: reference // reference received for Payment Gateway
                    });

                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err);
                }
            });

        }
        
    }
</script>

<script>
    let paymentCheckout = new PaymentCheckout.modal({
        env_mode: "prod", // `prod`, `stg`, `local` to change environment. Default is `stg`
        onOpen: function () {
            console.log("modal open");
        },
        onClose: function () {
            $('#payment-method-card').prop( "checked", false );
            console.log("modal closed");
        },
        onResponse: function (response) { // The callback to invoke when the Checkout process is completed

            if(response.transaction.status == 'success' && response.transaction.status_detail == 3){
                $('#paymentez_response').val(JSON.stringify(response))
                $('#form').submit()
            }
            else
            {
                alert(response.error.description)
            }
            document.getElementById("response").innerHTML = JSON.stringify(response);
            console.log('answer' + JSON.stringify(response))
        }
    });

    window.addEventListener('popstate', function () {
        paymentCheckout.close();
    });
</script>

<!--main area-->
@endsection