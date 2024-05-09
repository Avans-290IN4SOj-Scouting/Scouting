<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ManageStockController extends Controller
{
    public function index()
    {
        $products = Product::with(['productType', 'productSizes'])->get();

        //only for frontend
        $all_products = ['Product 1', 'Product 2', 'Product 3'];
        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        $colors = ['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White'];

        return view("admin.stock", ['products' => $products, 'all_products' => $all_products, 'sizes' => $sizes, 'colors' => $colors]);
    }

}
