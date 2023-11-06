<?php

namespace App\Http\Livewire;

use App\Models\Bracelet;
use App\Models\Coupon;
use App\Models\Product;
use Livewire\Component;
use Cart;
use App\Providers\AWS\S3;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Gloudemans\Shoppingcart\Facades\Cart as FacadesCart;
use PhpParser\Node\Stmt\Break_;
use Illuminate\Support\Facades\Auth;

class CartComponent extends Component
{
    public $haveCouponCode;
    public $couponCode;
    public $discount;
    public $subtotalAfterDiscount;
    public $taxAfterDiscount;
    public $totalAfterDiscount;
    public $shippingFee = 3;
    public $shippingTaxFee;

    public function render()
    {
        $this->shippingTaxFee = ($this->shippingFee * config('cart.tax'))/100;
        if(session()->has('coupon'))
        {
            if(Cart::instance('cart')->subtotal() < session()->get('coupon')['cart_value'])
            {
                session()->forget('coupon');
            }
            else
            {
                $this->calculateDiscounts();
            }
        }
        $this->setAmountforCheckout();
        return view('livewire.cart-component')->layout('layouts.base');
    }

    public function increaseQuantity($rowId)
    {
        $productCart = Cart::instance('cart')->get($rowId);

        if($productCart->options->productType == 'product')
        {
            // $product = Product::find($productCart->id);
            // if($productCart->qty < $product->quantity)
            if($productCart->qty < $productCart->options->stock)
            {
                $qty = $productCart->qty + 1;
                Cart::instance('cart')->update($rowId,['qty'=>$qty]);
            }
            else
            {
                session()->flash('stock_message', 'There is no more stock of item: ' . $productCart->name);
            }
        }
        else
        {
            $qty = $productCart->qty + 1;
            Cart::instance('cart')->update($rowId,['qty'=>$qty]);
        }

    }

    public function decreaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        if($qty > 0){
            Cart::instance('cart')->update($rowId,['qty'=>$qty]);
            $this->checkSummerCode(); //CHECKS QUANTITY FOR SUMMER CODE
        }
    }

    public function checkSummerCode()
    {
        if(session()->has('coupon'))
        {
            if(session()->get('coupon')['code'] == 'SUMMER2023' && Cart::instance('cart')->count() <= 2)
            {
                session()->flash('coupon_message', 'You must have more than 2 items to apply this coupon');
                $this->removeCoupon();
                return;
            }
        }
    }

    public function delete($rowId)
    {
        // get product from cart
        $product = Cart::instance('cart')->get($rowId);

        // only for custom bracelet
        if($product->options->productType !== null && $product->options->productType == 'custom_bracelet')
        {
            S3::eliminarArchivoS3($product->options->image);
            Bracelet::destroy($product->id);
        }

        //remove product from cart
        Cart::instance('cart')->remove($rowId);
        $this->checkSummerCode(); //CHECKS QUANTITY FOR SUMMER CODE
        session()->flash('success_message', 'Item has been removed');
    }

    public function applyCouponCode()
    {
        $coupon = Coupon::where('code',$this->couponCode)->where('expiry_date','>=',Carbon::today())->where('cart_value','<=',Cart::instance('cart')->subtotal())->first();
        
        if(!$coupon)
        {
            session()->flash('coupon_message', 'Coupon code is invalid or already expired');
            return;
        }

        if($coupon->code == 'SUMMER2023' && Cart::instance('cart')->count() <= 2)
        {
            session()->flash('coupon_message', 'You must have more than 2 items to apply this coupon');
            return;
        }

        session()->put('coupon',[
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value
        ]);
    }

    public function calculateDiscounts()
    {
        if(session()->has('coupon'))
        {
            if(session()->get('coupon')['code'] == 'SUMMER2023')
            {
                $discount = 0;
                foreach (Cart::instance('cart')->content() as $item) {
                    if($item->price > $discount){
                        $discount = $item->price;
                    }
                }
                $this->discount = $discount;
            }
            else
            {
                if(session()->get('coupon')['type']=='fixed')
                {
                    $this->discount = session()->get('coupon')['value'];
                }
                else
                {
                    $this->discount = (Cart::instance('cart')->subtotal() * session()->get('coupon')['value'])/100;
                }

            }

            $this->subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $this->discount;
            $this->taxAfterDiscount = ($this->subtotalAfterDiscount * config('cart.tax'))/100;
            $this->totalAfterDiscount = $this->subtotalAfterDiscount + $this->taxAfterDiscount;

        }
        
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
    }

    public function checkout()
    {
        if(Cart::instance('cart')->total() + $this->shippingFee + $this->shippingTaxFee >= 12)
        {
            if(Auth::check())
            {
                return redirect('/checkout');
            }
            else
            {
                return redirect('/login')->with(['guest_checkout' => true]);
            }
        }
        else
        {
            session()->flash('error_message', 'Minimun purchase is $12!');
        }
    }

    public function setAmountforCheckout()
    {
        if(!Cart::instance('cart')->count() > 0)
        {
            session()->forget('checkout');
            return;
        }
        if(session()->has('coupon'))
        {
            session()->put('checkout',[
                'discount' => $this->discount,
                'subtotal' => $this->subtotalAfterDiscount,
                'tax' => $this->taxAfterDiscount,
                'total' => $this->totalAfterDiscount + $this->shippingFee,
                'shipping' => $this->shippingFee
            ]);
        }
        else
        {
            session()->put('checkout',[
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax() + $this->shippingTaxFee,
                'total' => Cart::instance('cart')->total() + $this->shippingFee + $this->shippingTaxFee,
                'shipping' => $this->shippingFee
            ]);
        }
    }

    public function clearCart()
    {
        Cart::instance('cart')->destroy();
    }

}
