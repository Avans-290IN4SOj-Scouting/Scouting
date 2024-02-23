<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    // GET
    public function index()
    {
        $product1 = new Product;
        $product1->name = 'Banaan';
        $product1->price = '12,34';
        $product1->salePrice = '11,22';
        $product1->imageUri = 'https://placehold.co/150x150';
        $product1->amount = '1';

        $product2 = new Product;
        $product2->name = 'Appel';
        $product2->price = '12,34';
        $product2->salePrice = '11,22';
        $product2->imageUri = 'https://placehold.co/150x150';
        $product2->amount = '2';

        $product3 = new Product;
        $product3->name = 'Peer';
        $product3->price = '12,34';
        $product3->salePrice = '11,22';
        $product3->imageUri = 'https://placehold.co/150x150';
        $product3->amount = '3';

        $products = [
            $product1,
            $product2,
            $product3
        ];

        return view('orders.shoppingcart', [
            'products' => $products,
        ]);
    }

    // POST
    public function insert(string $id)
    {
        dd('Cart received: ' . $id);

        // TODO: add logic for shopping cart
    }

    public function remove(string $id)
    {

    }

    public function setAmount(string $id, string $amount)
    {

    }

    public function addAmount(string $id, string $amount)
    {

    }
}
