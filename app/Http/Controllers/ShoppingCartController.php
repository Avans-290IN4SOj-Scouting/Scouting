<?php

namespace App\Http\Controllers;

use App\Services\ShoppingCartService;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function __construct(
        protected ShoppingCartService $shoppingCartService
    ) { }

    // GET
    public function index()
    {
        $products = $this->shoppingCartService->getShoppingCartProducts();
        $prices = $this->shoppingCartService->getPrices($products);

        return view('orders.shoppingcart', [
            'products' => $products,
            'prices' => $prices
        ]);
    }

    // POST response
    public function update(Request $request)
    {
        $products = $this->shoppingCartService->getShoppingCartProducts();
        $priceChange = $this->shoppingCartService->getPrices($products);

        return response()->json(['success' => true, 'priceChange' => json_encode($priceChange)]);
    }
}
