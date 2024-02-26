<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class JsShoppingCart {
    public $products;
}

class JsProduct {
    public $id;
    public $amount;
}

class ShoppingCartController extends Controller
{
    // GET
    public function index()
    {
        $products = [];
        $shoppingCartCookie = $_COOKIE['shopping-cart'];
        $shoppingCart = json_decode($shoppingCartCookie);
        foreach ($shoppingCart->products as $shoppingCartProduct) {
            $product = OrderController::getProduct($shoppingCartProduct->id);
            $product->amount = $shoppingCartProduct->amount;
            array_push($products, $product);
        }

        return view('orders.shoppingcart', [
            'products' => $products,
        ]);
    }
}
