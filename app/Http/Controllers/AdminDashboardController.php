<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\AWS\S3;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\TrackingNumberMail;
use App\Models\Category;
use App\Models\Parametros;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File; 

class AdminDashboardController extends Controller
{
    ////////////////////
    // DASHBOARD DATA //
    ////////////////////
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get()->take(10);
        $totalSales = Order::where('status', 'delivered')->count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total');
        $todaylSales = Order::where('status', 'delivered')->whereDate('created_at', Carbon::today())->count();
        $todayRevenue = Order::where('status', 'delivered')->whereDate('created_at', Carbon::today())->sum('total');

        return view('livewire.admin.admin-dashboard',[
            'orders' => $orders,
            'totalSales' => $totalSales,
            'totalRevenue' => $totalRevenue,
            'todaySales' => $todaylSales,
            'todayRevenue' => $todayRevenue
        ]);
    }

                  //////////////////////
    //************// PRODUCTS SECTION //************//
                  //////////////////////
    use WithPagination;
    public function listProducts()
    {
        $products = Product::paginate(15);
        foreach($products as $product){
            if(str_contains($product->image, '["')){
                $product->image = json_decode($product->image);
            }
            else{
                $product->image = [$product->image];
            }
        }

        return view('livewire.admin.admin-products',[
            'products'=>$products
        ]);
    }

    public function createProduct()
    {
        $categories = Category::all();
        $sizesDB = Parametros::where('parNombre', 'sizes')->first();
        $sizes = explode(',',$sizesDB->parValor);
        $colorsDB = Parametros::where('parNombre', 'productColors')->first();
        $colors = explode(',',$colorsDB->parValor);
        return view('livewire.admin.admin-add-product-component',[
            'categories' => $categories,
            'sizes' => $sizes,
            'colors' => $colors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeProduct(Request $request)
    {
        //validations
        $this->validate($request,[
            'name' => 'required',
            'regular_price' => 'required|numeric',
            // 'quantity' => 'required|numeric',
            'stock_status' => 'required',
            'product_image' => 'required',
            'size' => 'required',
            'category' => 'required',
        ]);

        // save product into db
        $input = $request->all();
        $product = new Product();
        $product->name = $input['name'];
        $product->short_description = null;
        $product->description = $input['description'];
        $product->regular_price = $input['regular_price'];
        $product->sale_price = $input['sale_price'];
        $product->stock_status = $input['stock_status'];
        if(isset($input['color'])){
            $product->color = $input['color'];
        }else{
            $product->color = null;
        }

        $sizes = [];
        $size_qty = array_values(array_filter($input['size_qty'])); //filters empty spaces in array
        foreach($input['size'] as $i => $size){
            $data = ['size' => $size, 'qty' => $size_qty[$i]];
            array_push($sizes, $data);
        }
        $product->size_qty = json_encode($sizes);
        $product->quantity = array_sum($size_qty);
        $product->category = explode('|',$input['category'])[0];

        $subcategories = [];
        if(isset($input['subcategories'])){
            foreach($input['subcategories'] as $subcategory){
                array_push($subcategories, $subcategory);
            }
        }
        $product->subcategories = json_encode($subcategories);

        // getting image and uploading to bucket in S3
        if($request->file('product_image') !== null){
            $images = [];
            foreach($request->file('product_image') as $file){
                $fileName = $file->getClientOriginalName();
                $file->store('public/images');
                $url = S3::subirArchivoS3($file,$fileName);
                File::delete($fileName);
                array_push($images, $url);
            }
            $product->image = json_encode($images);
        }
        $product->save();

        session()->flash('message', 'Product has been created successfully!');
        return redirect('/admin/products');
    }

    /**
     * Edit a resource from storage.
     */
    public function editProduct($id){
        $product = Product::find($id);
        $product->size_qty = json_decode($product->size_qty);
        $productSizes = [];
        if($product->size_qty !== null){
            foreach($product->size_qty as $x){
                $productSizes[$x->size] = $x->qty;
            }
        }
        $product->image = json_decode($product->image);
        $sizesDB = Parametros::where('parNombre', 'sizes')->first();
        $sizes = explode(',',$sizesDB->parValor);
        $colorsDB = Parametros::where('parNombre', 'productColors')->first();
        $colors = explode(',',$colorsDB->parValor);
        $categories = Category::all();
        return view('livewire.admin.admin-edit-product-component',[
            'product' => $product,
            'sizes' => $sizes,
            'productSizes' => $productSizes,
            'colors' => $colors,
            'categories' => $categories
        ]);
    }

    /**
     * Update a resource in storage.
     */
    public function updateProduct(Request $request)
    {
        //validations
        $this->validate($request,[
            'name' => 'required',
            'regular_price' => 'required|numeric',
            // 'quantity' => 'required|numeric',
            'stock_status' => 'required',
            'size' => 'required',
            'category' => 'required',
        ]);

        // update product from db
        $input = $request->all();
        $product = Product::find($input['id']);

        $product->name = $input['name'];
        $product->short_description = null;
        $product->description = $input['description'];
        $product->regular_price = $input['regular_price'];
        $product->sale_price = $input['sale_price'];
        $product->color = $input['color'];
        $product->stock_status = $input['stock_status'];

        $sizes = [];
        $size_qty = array_values(array_filter($input['size_qty'])); //filters empty spaces in array
        foreach($input['size'] as $i => $size){
            $data = ['size' => $size, 'qty' => $size_qty[$i]];
            array_push($sizes, $data);
        }
        $product->size_qty = json_encode($sizes);
        $product->quantity = array_sum($size_qty);
        $product->category = explode('|',$input['category'])[0];

        $subcategories = [];
        if(isset($input['subcategories'])){
            foreach($input['subcategories'] as $subcategory){
                array_push($subcategories, $subcategory);
            }
        }
        $product->subcategories = json_encode($subcategories);

        // getting image and uploading to bucket in S3
        if($request->file('product_image') !== null){
            S3::eliminarArchivoS3($product->image);
            $file = $request->file('product_image');
            $fileName = $file->getClientOriginalName();
            $url = S3::subirArchivoS3($file,$fileName);
            $product->image = $url;
        }

        // getting image and uploading to bucket in S3
        if($request->file('product_image') !== null){
            $images = [];
            foreach($product->image as $image){
                S3::eliminarArchivoS3($image);
            }
            foreach($request->file('product_image') as $file){
                $fileName = $file->getClientOriginalName();
                $file->store('public/images');
                $url = S3::subirArchivoS3($file,$fileName);
                File::delete($fileName);
                array_push($images, $url);
            }
            $product->image = json_encode($images);
        }
        $product->save();

        session()->flash('message', 'Product has been updated successfully!');
        return redirect('/admin/products');
    }

    /**
     * Destroys a resource from storage.
     */
    public function destroyProduct($id){
        $product = Product::find($id);
        if($product->image !== null){
            if(str_contains($product->image, '["')){
                $product->image = json_decode($product->image);
            }
            else{
                $product->image = [$product->image];
            }
            foreach($product->image as $image){
                S3::eliminarArchivoS3($image);
            }
        }
        Product::destroy($id);

        session()->flash('message', 'Product has been deleted successfully!');
        return redirect('/admin/products');
    }

    public function searchProduct($query)
    {
        if(str_contains($query,'||')){
            $query = str_replace('||', '/',$query);
        }
        $search = "%{$query}%";
        $products = Product::where('name','LIKE',$search)
                            ->orwhere('stock_status','LIKE',$search)
                            ->orwhere('regular_price','LIKE',$search)
                            ->orwhere('sale_price','LIKE',$search)
                            ->orderBy('id','DESC')
                            ->paginate(15);
        
        foreach($products as $product){
            if($product->image !== null){
                if(str_contains($product->image, '["')){
                    $product->image = json_decode($product->image);
                }
                else{
                    $product->image = [$product->image];
                }
            }
        }
        
        return view('livewire.admin.admin-products',[
            'products'=>$products
        ]);
    }

                  /////////////////////
    //************// COUPONS SECTION //***********//
                  /////////////////////
    use WithPagination;
    public function listCoupons()
    {
        $coupons = Coupon::paginate(20);
        return view('livewire.admin.admin-coupons',[
            'coupons'=>$coupons
        ]);
    }

    public function createCoupon()
    {
        return view('livewire.admin.admin-add-coupon');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCoupon(Request $request)
    {
        $this->validate($request,[
            'code' => 'required|unique:coupons',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required'
        ]);

        // save coupon into db
        $input = $request->all();
        $coupon = new Coupon();
        $coupon->code = $input['code'];
        $coupon->type = $input['type'];
        $coupon->value = $input['value'];
        $coupon->cart_value = $input['cart_value'];
        $coupon->expiry_date = date("Y-m-d", strtotime($input['expiry_date']));
        $coupon->save();

        session()->flash('message', 'Coupon has been created successfully!');
        return redirect('/admin/coupons');
    }

    /**
     * Edit a resource from storage.
     */
    public function editCoupon($id){
        $coupon = Coupon::find($id);
        return view('livewire.admin.admin-edit-coupon',[
            'coupon' => $coupon
        ]);
    }

    /**
     * Update a resource in storage.
     */
    public function updateCoupon(Request $request)
    {
        $this->validate($request,[
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required'
        ]);

        // update product from db
        $input = $request->all();
        $coupon = Coupon::find($input['id']);

        $coupon->code = $input['code'];
        $coupon->type = $input['type'];
        $coupon->value = $input['value'];
        $coupon->cart_value = $input['cart_value'];
        $coupon->expiry_date = date("Y-m-d", strtotime($input['expiry_date']));
        $coupon->save();

        session()->flash('message', 'Coupon has been updated successfully!');
        return redirect('/admin/coupons');
    }

    /**
     * Destroys a resource from storage.
     */
    public function destroyCoupon($id){
        Coupon::destroy($id);

        session()->flash('message', 'Coupon has been deleted successfully!');
        return redirect('/admin/coupons');
    }

                  ////////////////////
    //************// ORDERS SECTION //************//
                  ////////////////////
    use WithPagination;
    public function listOrders()
    {
        $orders = Order::orderBy('created_at','DESC')->paginate(20);
        return view('livewire.admin.admin-order',[
            'orders'=>$orders
        ]);
    }

    public function orderDetails($id)
    {
        $order = Order::find($id);
        return view('livewire.admin.admin-order-details',[
            'order'=>$order
        ]);
    }

    public function updateOrderStatus($id, $status)
    {
        $order = Order::find($id);
        $order->status = $status;
        if($status == 'delivered')
        {
            $order->delivered_date = DB::raw('CURRENT_DATE');
        }
        elseif($status == 'canceled')
        {
            $order->canceled_date = DB::raw('CURRENT_DATE');
        }
        $order->save();
        session()->flash('order_message','Order status has been updated successfully!');
        return redirect('/admin/orders');
    }

    public function addTrackingDetails(Request $request)
    {
        $input = $request->all();
        $order = Order::find($input['id']);
        $order->shipping_company = $input['shipping_company'];
        $order->tracking_number = $input['tracking_number'];
        $order->save();

        if($input['send_mail'])
        {
            $this->sendTrackingMail($order->id);
            session()->flash('order_message','Tracking number added for order No. ' . $order->order_number . ' and tracking mail sent to ' . $order->email);
        }
        else
        {
            session()->flash('order_message','Tracking number added for order No. ' . $order->order_number);
        }
        return redirect('/admin/orders');
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
        
        return view('livewire.admin.admin-order',[
            'orders'=>$orders
        ]);
    }

    public function sendTrackingMail($id)
    {
        $order = Order::find($id);
        session()->flash('order_message','Tracking mail has been sent for order No. ' . $order->order_number . ' to ' . $order->email);
        Mail::to($order->email)->send(new TrackingNumberMail($order));
        return back();
    }

                  ////////////////////////
    //************// CATEGORIES SECTION //***********//
                  ////////////////////////
    use WithPagination;
    public function listCategories()
    {
        $categories = Category::paginate(20);
        return view('livewire.admin.admin-categories',[
            'categories'=>$categories
        ]);
    }

    public function createCategory()
    {
        return view('livewire.admin.admin-add-category');
    }

    public function storeCategory(Request $request)
    {
        $this->validate($request,[
            'type' => 'required'
        ]);

        // save coupon into db
        $input = $request->all();
        $category = new Category();
        $category->type = $input['type'];
        $category->subtype = $input['subtype'];
        $category->save();

        session()->flash('message', 'Category has been created successfully!');
        return redirect('/admin/categories');
    }

    public function editCategory($id){
        $category = Category::find($id);
        return view('livewire.admin.admin-edit-category',[
            'category' => $category
        ]);
    }

    public function updateCategory(Request $request)
    {
        $this->validate($request,[
            'type' => 'required',
        ]);

        // update category from db
        $input = $request->all();
        $category = Category::find($input['id']);

        $category->type = $input['type'];
        $category->subtype = $input['subtype'];
        $category->save();

        session()->flash('message', 'Category has been updated successfully!');
        return redirect('/admin/categories');
    }

    /**
     * Destroys a resource from storage.
     */
    public function destroyCategory($id){
        Category::destroy($id);

        session()->flash('message', 'Category has been deleted successfully!');
        return redirect('/admin/categories');
    }

    ///////////////////
    // USERS SECTION //
    ///////////////////
    use WithPagination;
    public function listUsers()
    {
        $users = User::paginate(20);
        return view('livewire.admin.admin-users',[
            'users'=>$users
        ]);
    }
}
