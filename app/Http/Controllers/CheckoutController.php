<?php

namespace App\Http\Controllers;

use App\Models\Bracelet;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\Parametros;
use App\Mail\OrderMail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Cart;
use Exception;
use Stripe;
use Omnipay\Omnipay;
use \Datetime;

class CheckoutController extends Controller
{
    private $gateway;

    public function index()
    {
        if(!session()->get('checkout')){
            return redirect('/cart');
        }

        return view('livewire.checkout-component');
    }

    public function placeOrder(Request $request)
    {        
        self::fieldValidations($request);
        $input = $request->all();

        if($this->checkItemsStock())
        {
            if($request->all()['payment_method'] == 'paypal')
            {
                return $this->paypalPayment($input);
            }
            elseif($request->all()['payment_method'] == 'card')
            {
                return $this->stripePayment($input);
            }
        }
        else
        {
            session()->flash('stripe_error',"Some items in the cart are not available anymore!");
            return back();
        }
    }

    public function checkItemsStock()
    {
        // this method is used to double check if all the products have stock before buying it
        $stock = true;
        foreach(Cart::instance('cart')->content() as $item)
        {
            $product_stock = Product::find($item->id);
            if($item->options->productType == 'product')
            {
                if($product_stock->quantity = 0 || $item->qty > $product_stock->quantity)
                {
                    $stock = false;
                }
            }
        }
        return $stock;
    }

    public function saveOrder($input)
    {
        $order = new Order();
        if(isset(Auth::user()->id)){
            $order->user_id = Auth::user()->id;
        }else{
            $order->user_id = 0; //for guest checkout
        }
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->discount = session()->get('checkout')['discount'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'];
        $order->firstname = $input['firstname'];
        $order->lastname = $input['lastname'];
        $order->mobile = $input['mobile'];
        $order->email = $input['email'];
        $order->line1 = $input['address'];
        $order->city = $input['city'];
        $order->province = $input['state'];  
        $order->country = $input['country'];
        $order->zipcode = $input['zipcode'];
        $order->status = 'ordered';
        $order->is_shipping_different = $input['ship_to_different'];
        $paymentes_response = json_decode($input['paymentez_response'], true);
        $order->authorization_code = $paymentes_response['transaction']['authorization_code'];
        $order->transaction_id = $paymentes_response['transaction']['id'];
        date_default_timezone_set($this->get_local_time());
        $currentDateTime = date('Y-m-d H:i:s');
        $order->created_at = $currentDateTime;
        $order->save();
        
        $orderDB = $order->refresh();
        $code = self::getRandomCode();
        $orderDB->order_number = $orderDB->id .'&' . $code;
        $orderDB->save();

        foreach(Cart::instance('cart')->content() as $item)
        {
            $orderItem = new OrderItem();
            if($item->options->productType == 'product'){
                $orderItem->product_id = $item->id;
            }elseif($item->options->productType == 'custom_bracelet'){
                $orderItem->bracelet_id = $item->id;
            }
            $orderItem->order_id = $order->id;
            $orderItem->product_name = $item->name;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->image = $item->options->image[0];
            $orderItem->save();
        }

        // // saves billing and shipping addr depending if they are the same or not
        if($input['ship_to_different']) 
        {
            $shipping = new Shipping();
            $shipping->order_id = $order->id;
            $shipping->firstname = $input['shipping_firstname'];
            $shipping->lastname = $input['shipping_lastname'];
            $shipping->email = $input['shipping_email'];
            $shipping->mobile = $input['shipping_mobile'];
            $shipping->line1 = $input['shipping_address'];
            $shipping->city = $input['shipping_city'];
            $shipping->province = $input['shipping_state'];
            $shipping->country = $input['shipping_country'];
            $shipping->zipcode = $input['shipping_zipcode'];
            $shipping->save();
        }
        else
        {
            $shipping = new Shipping();
            $shipping->order_id = $order->id;
            $shipping->firstname = $input['firstname'];
            $shipping->lastname = $input['lastname'];
            $shipping->email = $input['email'];
            $shipping->mobile = $input['mobile'];
            $shipping->line1 = $input['address'];
            $shipping->city = $input['city'];
            $shipping->province = $input['state'];
            $shipping->country = $input['country'];
            $shipping->zipcode = $input['zipcode'];
            $shipping->save();
        }
        return $orderDB;
    }

    public function paypalPayment($input)
    {
        $clientID = Parametros::where('parNombre','clientIdPaypal')->first();
        $secretKey = Parametros::where('parNombre','secretKeyPaypal')->first();

        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId($clientID->parValor);
        $this->gateway->setSecret($secretKey->parValor);
        $this->gateway->setTestMode(true);

        try{
            $response = $this->gateway->purchase([
                'amount' => session()->get('checkout')['total'],
                'currency' => 'USD',
                'returnUrl' => url('/success-paypal'),
                'cancelUrl' => url('/error-paypal')
            ])->send();

            if($response->isRedirect())
            {
                session()->put('order',$input);
                $response->redirect();
            }
            else
            {
                session()->flash('stripe_error',$response->getMessage());
                return back()->withInput();
            }

        } catch(\Throwable $th){

            session()->flash('stripe_error',$th->getMessage());
            return back()->withInput();
        }
    }

    public function successPaypal(Request $request)
    {
        if($request->input('paymentId') && $request->input('PayerID'))
        {
            $clientID = Parametros::where('parNombre','clientIdPaypal')->first();
            $secretKey = Parametros::where('parNombre','secretKeyPaypal')->first();

            $gateway = Omnipay::create('PayPal_Rest');
            $gateway->setClientId($clientID->parValor);
            $gateway->setSecret($secretKey->parValor);
            $gateway->setTestMode(true);

            $transaction = $gateway->completePurchase([
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ]);

            $response = $transaction->send();

            if($response->isSuccessful())
            {
                $data = $response->getData();
                $input = session()->get('order');
                $order = $this->saveOrder($input);
                $this->makeTransaction($order->id,$data['state'],'paypal');
                $this->makePurchase($order);

                return redirect('/thankyou')->with([
                    'order_number' => $order->order_number,
                    'email' => $order->email,
                ]);
            }
            else
            {
                session()->flash('stripe_error',$response->getMessage());
                return back()->withInput();
            }
        }
        else
        {
            session()->flash('stripe_error','Payment is declined!');
            return back()->withInput();
        }
    }

    public function errorPaypal()
    {
        return 'User declined the payment!';
    }

    public function stripePayment($input)
    {

        $stripeKey = Parametros::where('parNombre', 'stripeKey')->first();
        $stripe = Stripe::make($stripeKey->parValor);

        try{
            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $input['card_number'],
                    'exp_month' => explode('/',$input['exp_date'])[0],
                    'exp_year' => '20' . explode('/',$input['exp_date'])[1],
                    'cvc' => $input['cvc_code'],
                ]
            ]);

            if(!isset($token['id']))
            {
                session()->flash('stripe_error',"The stripe token wasn't generated correctly!");
                return back();

            }

            $customer = $stripe->customers()->create([
                'name' => $input['firstname'] . ' ' . $input['lastname'],
                'email' => $input['email'],
                'phone' => $input['mobile'],
                'address' => [
                    'line1' => $input['address'],
                    'postal_code' => $input['zipcode'],
                    'city' => $input['city'],
                    'state' => $input['state'],
                    'country' => $input['country']
                ],
                'shipping' => [
                    'name' => $input['firstname'] . ' ' . $input['lastname'],
                    'address' => [
                        'line1' => $input['address'],
                        'postal_code' => $input['zipcode'],
                        'city' => $input['city'],
                        'state' => $input['state'],
                        'country' => $input['country']
                    ],
                ],
                'source' => $token['id']
            ]);

            $order = $this->saveOrder($input);
            $charge = $stripe->charges()->create([
                'customer' => $customer['id'],
                'currency' => 'USD',
                'amount' => session()->get('checkout')['total'],
                'description' => 'Payment for order no ' . $order->id,
                'receipt_email' => $input['email']
            ]);

            if($charge['status'] == 'succeeded')
            {
                $this->makeTransaction($order->id,'approved','card');
                $this->makePurchase($order);
                return redirect('/thankyou')->with([
                    'order_number' => $order->order_number,
                    'email' => $order->email,
                ]);
            }
            else
            {
                session()->flash('stripe_error','Error in transaction!');
                return back()->withInput();
            }
        
        }catch(Exception $e){
            session()->flash('stripe_error',$e->getMessage());
            return back()->withInput();
        }

    }

    public function makePurchase($order)
    {
        //updates product stock
        foreach(Cart::instance('cart')->content() as $item)
        {
            if($item->options->productType == 'product')
            {
                $product = Product::find($item->id);
                $product->quantity = $product->quantity - $item->qty;
                $product->size_qty = json_decode($product->size_qty);

                foreach($product->size_qty as $x){
                    if($x->size == $item->options->size){
                        $x->qty = $x->qty - $item->qty;
                    }
                }

                $product->size_qty = json_encode($product->size_qty);
                
                if($product->quantity <= 0)
                {
                    $product->stock_status = 'outofstock';
                }
                $product->save();
            }
        }
        $this->isSoldBracelet();
        Cart::instance('cart')->destroy();
        // session()->forget('checkout');
        $this->sendOrderConfirmationMail($order);
        $this->sendOrderToAdmin($order);
    }

    function getRandomCode() 
    {
        $word = array_merge(range('a', 'z'), range('A', 'Z'));
        shuffle($word);
        return strtoupper(substr(implode($word), 0, 4));
    }

    public static function sendOrderConfirmationMail($order)
    {
        $shipping = Shipping::where('order_id', $order->id)->first();
        Mail::to($order->email)->send(new OrderMail($order,$shipping));
    }

    public static function sendOrderToAdmin($order)
    {
        $shipping = Shipping::where('order_id', $order->id)->first();
        Mail::to('jmales@alumni.usfq.edu.ec')->send(new OrderMail($order,$shipping));
    }

    public static function isSoldBracelet()
    {
        foreach(Cart::instance('cart')->content() as $item)
        {
            if($item->options->productType == 'custom_bracelet'){
                $bracelet = Bracelet::find($item->id);
                $bracelet->is_sold = true;
                $bracelet->save();
            }
        }
    }

    public static function makeTransaction($order_id,$status,$type)
    {
        $transaction = new Transaction();
        if(isset(Auth::user()->id)){
            $transaction->user_id = Auth::user()->id;
        }else{
            $transaction->user_id = 0; //for guest checkout
        }
        $transaction->order_id = $order_id;
        $transaction->mode = $type;
        $transaction->status = $status;
        $transaction->save();
    }

    public function checkOutAsGuest()
    {
        return redirect('/checkout')->with(['guest_checkout' => true]);
    }

    public function termsAndConditions()
    {
        return view('terms');
    }

    public function getPayPhonePaymentMethod($request)
    {
        $input = $request->all();
        $uri = 'https://pay.payphonetodoesposible.com/api/sale';
        $token = Parametros::where('parNombre', 'payPhoneToken')->first();

        $headers = [
            "Authorization:Bearer " . $token->parValor,
            "Accept-Encoding:application/json",
            "content-type: application/x-www-form-urlencoded",
        ];

        // $transactionData = [
        //     'clientTransactionId' => bin2hex(random_bytes(6)),
        //     'reference' => 'bracelets',
        //     'phoneNumber' => $input['mobile'],
        //     'countryCode' => '1',
        //     'email' => $input['email'],
        //     'currency' => 'USD',
        //     'amountWithoutTax' => session()->get('checkout')['subtotal'] * 100,
        //     'tax' => session()->get('checkout')['tax'] * 100,
        //     'amount' => session()->get('checkout')['total'] * 100,
        // ];

        $transactionData = [
            'clientTransactionId' => bin2hex(random_bytes(6)),
            'reference' => 'bracelets',
            'phoneNumber' => '0992200796',
            'countryCode' => '593',
            'email' => 'joelmales@gmail.com',
            'currency' => 'USD',
            'amountWithoutTax' => 10550,
            'tax' => 112,
            'amount' => 10700,
        ];
        

        $sale = self::getApi($uri,'POST',$headers, $transactionData);
        return $sale;
    }

    public static function getApi($uri,$type,$httpheaders,$postFields=[])
    {
        // $query = http_build_query($postFields);
        $query = json_encode($postFields);
        $curl = curl_init();

        if($type === 'POST'){
            curl_setopt_array($curl, [
                CURLOPT_URL => $uri,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $type,
                CURLOPT_POSTFIELDS => $query,
                CURLOPT_HTTPHEADER => $httpheaders,
            ]);
        }else{
            curl_setopt_array($curl, [
                CURLOPT_URL => $uri,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $type,
                CURLOPT_HTTPHEADER => $httpheaders,
            ]);
        }

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }

    }

    public function fieldValidations($request)
    {
        // if billing addr is different than shipping addr and card payment is selceted
        if($request->all()['ship_to_different'] && isset($request->all()['payment_method']) && $request->all()['payment_method'] == 'card') 
        {
            $this->validate($request,[
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'mobile' => 'required|numeric',
                'address' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
                'state' => 'required',
                'city' => 'required',
                'payment_method' => 'required',
                'shipping_firstname' => 'required',
                'shipping_lastname' => 'required',
                'shipping_email' => 'required|email',
                'shipping_mobile' => 'required|numeric',
                'shipping_address' => 'required',
                'shipping_country' => 'required',
                'shipping_zipcode' => 'required',
                'shipping_state' => 'required',
                'shipping_city' => 'required',
                'card_holder' => 'required',
                'card_number' => 'required|numeric',
                'exp_date' => 'required',
                'cvc_code' => 'required|numeric',
                'terms_conditions' => 'required'
            ]);
        }
        // if billing addr is same as shipping addr and card payment is selceted
        elseif(isset($request->all()['payment_method']) && $request->all()['payment_method'] == 'card'){
            $this->validate($request,[
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'mobile' => 'required|numeric',
                'address' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
                'state' => 'required',
                'city' => 'required',
                'payment_method' => 'required',
                'card_holder' => 'required',
                'card_number' => 'required|numeric',
                'exp_date' => 'required',
                'cvc_code' => 'required|numeric',
                'terms_conditions' => 'required'
            ]);
        }
        // if billing addr is different than shipping addr and no payment is selceted
        elseif($request->all()['ship_to_different']) 
        {
            $this->validate($request,[
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'mobile' => 'required|numeric',
                'address' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
                'state' => 'required',
                'city' => 'required',
                'payment_method' => 'required',
                'shipping_firstname' => 'required',
                'shipping_lastname' => 'required',
                'shipping_email' => 'required|email',
                'shipping_mobile' => 'required|numeric',
                'shipping_address' => 'required',
                'shipping_country' => 'required',
                'shipping_zipcode' => 'required',
                'shipping_state' => 'required',
                'shipping_city' => 'required',
                'terms_conditions' => 'required'
            ]);
        }
        else // if billing is same as shipping and no payment is selceted
        {
            $this->validate($request,[
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'mobile' => 'required|numeric',
                'address' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
                'state' => 'required',
                'city' => 'required',
                'payment_method' => 'required',
                'terms_conditions' => 'required'
            ]);
        }

    }

    public function placeOrderPaymentez(Request $request)
    {
        $input = $request->all();
        $order = $this->saveOrder($input);
        $this->makeTransaction($order->id,'approved','card');
        $this->makePurchase($order);
        return redirect('/thankyou')->with([
            'order_number' => $order->order_number,
            'transaction_id' => $order->transaction_id,
            'authorization_code'=> $order->authorization_code,
            'email' => $order->email,
        ]);
    }

    public function generateReference($name,$email)
    {
        $uri = 'https://ccapi.paymentez.com/v2/transaction/init_reference/';
        $token = self::authenticatePaymentez();

        $headers = [
            "Auth-Token: " . $token,
            "Content-Type: application/json",
        ];

        if(isset(Auth::user()->id)){
            $id_user = Auth::user()->id;
        }else{
            $id_user = 0; //for guest checkout
        }

        $parameters = [
            'locale' => 'en',
            'order' => [
                "amount" => session()->get('checkout')['total'],
                "description" => "Bracelet",
                "vat" => session()->get('checkout')['tax'],
                "dev_reference" => $name . " Buying",
                "installments_type" => 0,
                "taxable_amount" => session()->get('checkout')['total'] - session()->get('checkout')['tax'],
                "tax_percentage" => 12,
            ],
            'user' => [
                "id" => $id_user,
                "email" => $email
            ]
        ];

        $response = self::getApi($uri,'POST',$headers,$parameters);
        return $response;

    }

    public function authenticatePaymentez()
    {
        // $API_LOGIN_DEV     = "NUVEISTG-EC-SERVER"; 
        $API_LOGIN_DEV     = "BRACELETSNY-EC-SERVER"; 
        $api_key_dev = Parametros::where('parNombre', 'API_KEY_DEV_PROD')->first();
        $API_KEY_DEV = $api_key_dev->parValor;

        $server_application_code = $API_LOGIN_DEV;
        $server_app_key = $API_KEY_DEV ;
        $date = new DateTime();
        $unix_timestamp = $date->getTimestamp();
        $uniq_token_string = $server_app_key.$unix_timestamp;
        $uniq_token_hash = hash('sha256', $uniq_token_string);
        $auth_token = base64_encode($server_application_code.";".$unix_timestamp.";".$uniq_token_hash);

        return $auth_token;
        
    }

    public function refundPaymentez($id)
    {
        if(isset(Auth::user()->utype))
        {
            if(Auth::user()->utype == 'ADM')
            {
                $uri = 'https://ccapi.paymentez.com/v2/transaction/refund/';
                $token = self::authenticatePaymentez();
        
                $headers = [
                    "Auth-Token: " . $token,
                    "Content-Type: application/json",
                ];
        
                $parameters = [
                    'transaction' => [
                        "id" => $id,
                    ]
                ];

                //sets order status to 'canceled'
                $order = Order::where('transaction_id', $id)->first();
                $order->status = "canceled";
                date_default_timezone_set($this->get_local_time());
                $currentDateTime = date('Y-m-d H:i:s');
                $order->canceled_date = $currentDateTime;
                $order->save();
        
                $response = self::getApi($uri,'POST',$headers,$parameters);
                return $response;
            }
            else
            {
                return redirect('/');
            }
        }
        else
        {
            return redirect('/');
        }
        
    }

    public static function get_local_time()
    {
        $ip = file_get_contents("http://ipecho.net/plain");
        $url = 'http://ip-api.com/json/'.$ip;
        $tz = file_get_contents($url);
        $tz = json_decode($tz,true)['timezone'];
      
        return $tz;
    }

}
