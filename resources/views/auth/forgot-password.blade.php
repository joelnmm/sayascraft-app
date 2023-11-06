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
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span>Forgot Password</span></li>
            </ul>
        </div>
        <div class="row center" style="margin-top:60px">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 col-md-offset-3">
                <div class=" main-content-area">
                    <div class="wrap-login-item ">						
                        <div class="login-form form-item form-stl">
                            @if(session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <x-jet-validation-errors class="mb-4" />
                            <form name="frm-login" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <fieldset class="wrap-title">
                                    <h3 class="form-title">Forgot your password?</h3>										
                                    <div class="mb-4 text-sm text-gray-600">
                                        {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                                    </div>
                                </fieldset>
                                <fieldset class="wrap-input">
                                    <label for="frm-login-uname">Email Address:</label>
                                    <input type="email" id="email" name="email" placeholder="Type your email address" :value="old('email')" required autofocus autocomplete="username">
                                </fieldset>
                                
                                <input type="submit" class="btn btn-submit" value="Email Password Reset Link" name="submit" style="background-color: black;">
                            </form>
                        </div>												
                    </div>
                </div><!--end main products area-->		
            </div>
        </div><!--end row-->

    </div><!--end container-->
</x-guest-layout>
@endsection

