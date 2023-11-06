<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;

class ThankyouController extends Controller
{
    public function index()
    {
        if(!session()->get('checkout')){
            return redirect('/cart');
        }
        session()->forget('checkout');
        return view('livewire.thankyou');
    }
}
