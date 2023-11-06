<?php
  

use App\Http\Controllers\ProductsController;

if (!function_exists('addProduct')) {
    function addProduct($id,$name,$price)
    {
        ProductsController::addProductToCart($id,$name,$price);
    }
}