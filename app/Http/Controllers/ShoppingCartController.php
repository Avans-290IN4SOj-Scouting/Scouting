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
    public $size;
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
        $products = ShoppingCartController::getShoppingCartProducts();
        $prices = ShoppingCartController::getPrices($products);

        return view('orders.shoppingcart', [
            'products' => $products,
            'prices' => $prices
        ]);
    }

    public function update(Request $request)
    {
        $products = ShoppingCartController::getShoppingCartProducts();
        $priceChange = ShoppingCartController::getPrices($products);

        return response()->json(['success' => true, 'priceChange' => json_encode($priceChange)]);
    }

    public static function getPrices($products)
    {
        $amount = count($products);
        $totalPrice = 0.0;
        $totalSale = 0.0;
        foreach ($products as $product)
        {
            $productSize = null;
            foreach ($product->productSizes as $productProductSize)
            {
                if ($product->size == $productProductSize->size)
                {
                    $productSize = $productProductSize->pivot;
                    break;
                }
            }
            if ($productSize == null)
            {
                continue;
            }

            $totalPrice += $productSize->price * $product->amount;
            $totalSale += ($productSize->price - $product->salePrice) * $product->amount;
        }

        return new JsPriceChange($amount, $totalPrice, $totalSale);
    }

    public static function getShoppingCartProducts()
    {
        $products = [];
        $shoppingCart = new JsShoppingCart();

        if (!isset($_COOKIE['shopping-cart']))
        {
            $shoppingCart = new JsShoppingCart();
            $shoppingCart->products = [];
        }
        else
        {
            $shoppingCartCookie = $_COOKIE['shopping-cart'];
            $shoppingCart = json_decode($shoppingCartCookie);
        }

        foreach ($shoppingCart->products as $shoppingCartProduct)
        {
            $product = Product::find($shoppingCartProduct->id);
            $product->amount = $shoppingCartProduct->amount;
            $product->size = $shoppingCartProduct->size;
            array_push($products, $product);
        }

        return $products;
    }
}
