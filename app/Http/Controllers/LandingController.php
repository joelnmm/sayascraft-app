<?php

namespace App\Http\Controllers;

use App\Mail\ContactInfoMail;
use App\Models\Parametros;
use Illuminate\Support\Facades\Mail;
use Exception;


use Illuminate\Http\Request;
use Carbon\Carbon;  

class LandingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $showAd = Parametros::where('parNombre', 'showAd')->first();
        return view('landing.index',[
            'showAd' => $showAd->parValor
        ]);
    } 

    public function getContact(Request $request)
    {
        $input = $request->all();
        Mail::to('jmales@alumni.usfq.edu.ec')->send(new ContactInfoMail($input));
        session()->flash('success_message', 'Thank you! your contact info has been sent.');
        return redirect('/#contact');
    }

}
