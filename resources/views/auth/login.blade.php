@extends('layouts.base')
@section('content')
<style>
    .center{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    @media only screen and (min-width: 500px) and (max-width: 800px){
        .col-md-6 {
            width: 80%;
        }
    }
    @media only screen and (min-width: 800px) and (max-width: 1200px){
        .col-md-6 {
            width: 70%;
        }
    }
</style>
<x-guest-layout>

    <main id="main" class="main-site left-sidebar">

        <div class="container">

            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="/" class="link">home</a></li>
                    <li class="item-link"><span>login</span></li>
                </ul>
            </div>
            <div class="row center">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 col-md-offset-3">
                    <div class=" main-content-area">
                        <div class="wrap-login-item ">						
                            <div class="login-form form-item form-stl">
                                <x-jet-validation-errors class="mb-4" />
                                <form name="frm-login" method="POST" action="{{route('login')}}">
                                    @csrf
                                    <fieldset class="wrap-title">
                                        <h3 class="form-title">Log in to your account</h3>										
                                    </fieldset>
                                    <fieldset class="wrap-input">
                                        <label for="frm-login-uname">Email Address:</label>
                                        <input type="email" id="frm-login-uname" name="email" placeholder="Type your email address" :value="old('email')" required autofocus>
                                    </fieldset>
                                    <fieldset class="wrap-input">
                                        <label for="frm-login-pass">Password:</label>
                                        <input type="password" id="frm-login-pass" name="password" placeholder="************" required autocomplete="current">
                                    </fieldset>
                                    
                                    <fieldset class="wrap-input">
                                        <label class="remember-field">
                                            <input class="frm-input " name="remember" id="rememberme" value="forever" type="checkbox"><span>Remember me</span>
                                        </label>
                                        <a class="link-function left-position" href="{{route('password.request')}}" title="Forgotten password?">Forgotten password?</a>
                                    </fieldset>
                                    <input type="submit" class="btn btn-submit" value="Login" name="submit" style="background-color: black;">
                                    <div style="margin-top: -30px;">
                                        <a class="underline text-sm text-gray-600 hover:text-gray-900 pull-right" href="{{ url('/register') }}" >
                                            {{ __("Sign up") }}
                                        </a>   
                                    </div>
                                </form>
                            </div>										
                        </div>
                        @if(Session::has('guest_checkout'))
                        <div class="center" style="margin-top: -30px; margin-bottom:20px;"><p>or</p></div>	
                        <div class="center">
                            <a href="/checkout-guest" class="underline text-sm text-gray-600 hover:text-gray-900" style="font-size: 20px;">Continue as guest?</a>
                        </div>
                        @endif
                    </div>	
                </div>
            </div><!--end row-->

        </div><!--end container-->

    </main>
</x-guest-layout>
@endsection