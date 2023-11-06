<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CreateBraceletController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\ProductsComponent;
use App\Http\Livewire\TestComponent;
use App\Http\Controllers\ThankyouController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// when created by: php artisan make:controller LandingController --resource
Route::get('/', [LandingController::class, 'index']);
Route::post('/send-contact-info', [LandingController::class, 'getContact']);

Route::get('/create-bracelet', [CreateBraceletController::class, 'index']);
Route::post('/store-bracelet', [CreateBraceletController::class, 'store']);

Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products-sort/{parameter}/{category}/{color}', [ProductsController::class, 'sortProduct']);
Route::get('/product-add-cart/{id}/{page}/{size}/{qty}', [ProductsController::class, 'addProductToCart']);

Route::get('/cart', CartComponent::class);
Route::get('/test', TestComponent::class);

Route::get('/checkout', [CheckoutController::class, 'index']);
Route::get('/checkout-guest', [CheckoutController::class, 'checkOutAsGuest']);
Route::post('/place-order', [CheckoutController::class, 'placeOrder']);
Route::post('/place-order-paymentez', [CheckoutController::class, 'placeOrderPaymentez']);
Route::get('/generate-reference/{name}/{email}', [CheckoutController::class, 'generateReference']);
Route::get('/refund-transaction/{id}', [CheckoutController::class, 'refundPaymentez']);

Route::get('/thankyou', [ThankyouController::class, 'index']);
Route::get('/success-paypal', [CheckoutController::class, 'successPaypal']);
Route::get('/error-paypal', [CheckoutController::class, 'errorPaypal']);
Route::get('/terms-and-conditions', [CheckoutController::class, 'termsAndConditions']);


//For User or Customer
Route::middleware(['auth:sanctum','verified'])->group(function(){
    //dashboard
    Route::get('/user/dashboard',[UserDashboardController::class,'index'])->name('user.dashboard');

    //order routes
    Route::get('/user/orders',[UserDashboardController::class,'listOrders'])->name('user.orders');
    Route::get('/user/order-details/{id}', [UserDashboardController::class, 'orderDetails']);
    Route::get('/user/cancel-order/{id}', [UserDashboardController::class, 'cancelOrder']);
    Route::get('/user/search-order/{query}', [UserDashboardController::class, 'searchOrder']);

    //settings routes
    Route::get('/admin/user-settings', [UserDashboardController::class, 'userSettings'])->name('user.settings');

});

// For Admin
Route::middleware(['auth:sanctum','verified','authadmin'])->group(function(){
    Route::get('/admin/dashboard',[AdminDashboardController::class, 'index'])->name('admin.dashboard');

    //products routes
    Route::get('/admin/products',[AdminDashboardController::class, 'listProducts'])->name('admin.products');
    Route::get('/admin/create-product',[AdminDashboardController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/admin/store-product', [AdminDashboardController::class, 'storeProduct']);
    Route::get('/admin/edit-product/{id}', [AdminDashboardController::class, 'editProduct']);
    Route::post('/admin/update-product', [AdminDashboardController::class, 'updateProduct']);
    Route::get('/admin/destroy-product/{id}', [AdminDashboardController::class, 'destroyProduct']);
    Route::get('/admin/search-product/{query}', [AdminDashboardController::class, 'searchProduct']);
    Route::get('/admin/search-product/{query}', [AdminDashboardController::class, 'searchProduct']);

    //coupons routes
    Route::get('/admin/coupons', [AdminDashboardController::class, 'listCoupons'])->name('admin.coupons');;
    Route::get('/admin/create-coupon', [AdminDashboardController::class, 'createCoupon'])->name('admin.coupons.create');
    Route::post('/admin/store-coupon', [AdminDashboardController::class, 'storeCoupon']);
    Route::get('/admin/edit-coupon/{id}', [AdminDashboardController::class, 'editCoupon']);
    Route::post('/admin/update-coupon', [AdminDashboardController::class, 'updateCoupon']);
    Route::get('/admin/destroy-coupon/{id}', [AdminDashboardController::class, 'destroyCoupon']);

    //order routes
    Route::get('/admin/orders', [AdminDashboardController::class, 'listOrders'])->name('admin.orders');
    Route::get('/admin/order-details/{id}', [AdminDashboardController::class, 'orderDetails']);
    Route::get('/admin/order-update-status/{id}/{status}', [AdminDashboardController::class, 'updateOrderStatus']);
    Route::post('/admin/add-tracking', [AdminDashboardController::class, 'addTrackingDetails']);
    Route::get('/admin/search-order/{query}', [AdminDashboardController::class, 'searchOrder']);
    Route::get('/admin/send-tracking-mail/{id}', [AdminDashboardController::class, 'sendTrackingMail']);

    //categories routes
    Route::get('/admin/categories', [AdminDashboardController::class, 'listCategories'])->name('admin.categories');
    Route::get('/admin/create-category', [AdminDashboardController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/admin/store-category', [AdminDashboardController::class, 'storeCategory']);
    Route::get('/admin/edit-category/{id}', [AdminDashboardController::class, 'editCategory']);
    Route::post('/admin/update-category', [AdminDashboardController::class, 'updateCategory']);
    Route::get('/admin/destroy-category/{id}', [AdminDashboardController::class, 'destroyCategory']);

    //users routes
    Route::get('/admin/users', [AdminDashboardController::class, 'listUsers'])->name('admin.users');

});


