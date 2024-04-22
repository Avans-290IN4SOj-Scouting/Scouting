<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ManageProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        //only for frontend
        $total = 3;
        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        $colors = ['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White'];

        return view("admin.products", ['products' => $products, 'total' => $total, 'sizes' => $sizes, 'colors' => $colors]);
    }

}
