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

class JsPriceChange {
    public $amount;
    public $total;
    public $sale;

    public function __construct($amount, $total, $sale) {
        $this->amount = $amount;
        $this->total = $total;
        $this->sale = $sale;
    }
}

class ShoppingCartController extends Controller
{
    // GET
    public function index()
    {
        $products = $this->getShoppingCartProducts();
        return view('orders.shoppingcart', [
            'products' => $products,
        ]);
    }

    public function update(Request $request)
    {
        $products = $this->getShoppingCartProducts();
        $amount = count($products);
        $totalPrice = 0.0;
        $totalSale = 0.0;
        foreach ($products as $product)
        {
            $totalPrice += $product->price * $product->amount;
            $totalSale += ($product->price - $product->salePrice) * $product->amount;
        }

        $priceChange = new JsPriceChange($amount, $totalPrice, $totalSale);
        return response()->json(['success' => true, 'priceChange' => json_encode($priceChange)]);
    }

    public function getShoppingCartProducts() {
        $products = [];
        $shoppingCartCookie = $_COOKIE['shopping-cart'];
        $shoppingCart = json_decode($shoppingCartCookie);
        foreach ($shoppingCart->products as $shoppingCartProduct)
        {
            $product = OrderController::getProduct($shoppingCartProduct->id);
            $product->amount = $shoppingCartProduct->amount;
            array_push($products, $product);
        }

        return $products;
    }
}
