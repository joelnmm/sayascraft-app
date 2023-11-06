<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    //////////////////////
    // HOMEPAGE SECTION //
    //////////////////////
    public function index()
    {
        $orders = Order::orderBy('created_at','DESC')->where('user_id',Auth::user()->id)->get()->take(10); 
        $totalCost = Order::where('status','!=','canceled')->where('user_id',Auth::user()->id)->sum('total'); 
        $totalPurchased = Order::where('status','!=','canceled')->where('user_id',Auth::user()->id)->count(); 
        $totalDeliverd = Order::where('status','==','delivered')->where('user_id',Auth::user()->id)->count(); 
        $totalOrdered = Order::where('status','==','ordered')->where('user_id',Auth::user()->id)->count(); 
        // $totalCanceled = Order::where('status','==','canceled')->where('user_id',Auth::user()->id)->count(); 

        return view('livewire.user.user-dashboard-component',[
            // 'orders' => $orders,
            'totalCost' => $totalCost,
            'totalPurchased' => $totalPurchased,
            'totalDeliverd' => $totalDeliverd,
            'totalOrdered' => $totalOrdered
        ]);
    }

    ////////////////////
    // ORDERS SECTION //
    ////////////////////
    public function listOrders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->paginate(10);
        return view('livewire.user.user-order',[
            'orders' => $orders
        ]);
    }

    public function orderDetails($id)
    {
        $order = Order::find($id);
        return view('livewire.user.user-order-details',[
            'order'=>$order
        ]);
    }

    public function cancelOrder($id)
    {
        $order = Order::find($id);
        $order->status = "canceled";
        $order->canceled_date = DB::raw('CURRENT_DATE');
        $order->save();
        session()->flash('order_message', 'Order has been canceled!');
        return redirect('/user/order-details/'. $id);
    }

    public function searchOrder($query)
    {
        if(str_contains($query,'||')){
            $query = str_replace('||', '/',$query);
        }
        $search = "%{$query}%";
        $orders = Order::where('order_number','LIKE',$search)
                            ->orwhere('firstname','LIKE',$search)
                            ->orwhere('lastname','LIKE',$search)
                            ->orwhere('email','LIKE',$search)
                            ->orwhere('status','LIKE',$search)
                            ->orderBy('id','DESC')
                            ->paginate(10);
        
        return view('livewire.user.user-order',[
            'orders' => $orders
        ]);
    }

    ////////////////////
    // User settings //
    ////////////////////
    public function userSettings()
    {
        return view('livewire.user.user-settings');
    }
}
