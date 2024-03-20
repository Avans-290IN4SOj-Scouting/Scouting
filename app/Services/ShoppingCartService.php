<?php

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Builder;

// Classes to Match Javascript classes
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

    public function __construct($amount, $total) {
        $this->amount = $amount;
        $this->total = $total;
    }
}

class ShoppingCartService
{
    // Get total prices from an array of products
    public function getPrices($products)
    {
        try
        {
            $amount = count($products);
            $totalPrice = 0.00;

            foreach ($products as $product)
            {
                $totalPrice += ($product->price * $product->amount);
            }

            return new JsPriceChange($amount, round($totalPrice, 2));
        }
        catch (Exception $e)
        {
            $this->clearShoppingCart();
        }

        return new JsPriceChange(0, 0.00, 0.00);
    }

    // Get ShoppingCart's products from Cookie
    public function getShoppingCartProducts()
    {
        try
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
                $product = Product::join('product_product_size', 'products.id', '=', 'product_product_size.product_id')
                    ->join('product_sizes', 'product_sizes.id', '=', 'product_product_size.product_size_id')
                    ->where('products.id', '=', $shoppingCartProduct->id)
                    ->where('product_sizes.id', '=', $shoppingCartProduct->sizeId)
                    ->select('products.*', 'product_product_size.*', 'product_sizes.*')
                    ->first();

                // $product = Product::with(['productSizes' => function ($query) use ($shoppingCartProduct) {
                //         $query->where('product_size_id', '=', $shoppingCartProduct->sizeId);
                //     }])
                //     ->where('id', '=', $shoppingCartProduct->id)
                //     ->first();

                if ($product === null)
                {
                    continue;
                }

                $product->amount = $shoppingCartProduct->amount;
                $product->size = $product->size;
                array_push($products, $product);
            }

            return $products;
        }
        catch(Exception $e)
        {
            $this->clearShoppingCart();
        }

        return [];
    }

    public function clearShoppingCart()
    {
        $expiration_time = time() - 3600/*seconds*/;
        setcookie("shopping-cart", "", $expiration_time, "/");
    }
}
