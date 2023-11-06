@extends('layouts.admin-base')
@section('content')
<head>
    <link rel="stylesheet" type="text/css" href="/assets/css/form-bold.css">    
</head>

<div class="formbold-main-wrapper">
    <!-- Author: FormBold Team -->
    <!-- Learn More: https://formbold.com -->
    <div class="w-full">
        <div class="formbold-form-wrapper active">
        <div class="formbold-form-header">
            <h3>Create a coupon</h3>
            <button>
                <a href="{{ route('admin.coupons')}}" class="btn btn-success">All Coupons</a>
            </button>
        </div>
        <form action="{{url('admin/store-coupon')}}" method="POST" enctype="multipart/form-data" class="formbold-chatbox-form">
        @csrf
            <div class="formbold-mb-5">
                <label for="code" class="formbold-form-label">Coupon Code</label>
                @error('code')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="text" name="code" id="code" placeholder="Coupon Code" class="formbold-form-input"/>
            </div>

            <div class="formbold-mb-5">
                <label for="type" class="formbold-form-label">Type</label>
                @error('type')
                    <div class="error">{{ $message }}</div>
                @enderror
                <select name="type" id="type" class="formbold-form-input">
                    <option value="fixed"> Fixed</option>
                    <option value="percent"> Percent</option>
                </select>
            </div>

            <div class="formbold-mb-5">
                <label for="value" class="formbold-form-label">Value </label>
                @error('value')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="text" name="value" id="value" placeholder="00.00" class="formbold-form-input"/>
            </div>

            <div class="formbold-mb-5">
                <label for="cart_value" class="formbold-form-label">Cart Value </label>
                @error('cart_value')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="text" name="cart_value" id="cart_value" placeholder="00.00" class="formbold-form-input"/>
            </div>

            <div class="formbold-mb-5">
                <label for="expiry_date" class="formbold-form-label">Expiry Date </label>
                @error('expiry_date')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="date" name="expiry_date" id="expiry_date" placeholder="00.00" class="formbold-form-input"/>
            </div>

            <div>
                <button class="formbold-btn w-full" type="submit">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>
</body>

@endsection
