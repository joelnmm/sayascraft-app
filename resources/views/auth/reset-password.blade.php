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
                    <li class="item-link"><span>Reser Password</span></li>
                </ul>
            </div>
            <div class="row center">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 col-md-offset-3">							
                    <div class=" main-content-area">
                        <div class="wrap-login-item ">
                            <div class="register-form form-item ">
                            <x-jet-validation-errors class="mb-4" />
                                <form class="form-stl" action="{{ route('password.update') }}" name="frm-login" method="POST" >
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                    <fieldset class="wrap-title">
                                        <h3 class="form-title">Reset Password</h3>
                                    </fieldset>									
                                    <fieldset class="wrap-input">
                                        <label for="frm-reg-email">Email Address*</label>
                                        <input type="email" id="frm-reg-email" name="email" placeholder="Email address" :value="old('email', $request->email)" required autofocus autocomplete="username" >
                                    </fieldset>
                                    <fieldset class="wrap-input item-width-in-half left-item ">
                                        <label for="frm-reg-pass">Password *</label>
                                        <input type="password" id="frm-reg-pass" name="password" placeholder="Password" required autocomplete="new-password">
                                    </fieldset>
                                    <fieldset class="wrap-input item-width-in-half ">
                                        <label for="frm-reg-cfpass">Confirm Password *</label>
                                        <input type="password" id="frm-reg-cfpass" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                    </fieldset>
                                    <input type="submit" class="btn btn-sign" value="Reset Password" name="register" style="background-color: black;">
                                    
                                </form>
                            </div>											
                        </div>
                    </div><!--end main products area-->		
                </div>
            </div><!--end row-->

        </div><!--end container-->

    </main>
    
</x-guest-layout>
@endsection
