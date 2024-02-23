<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function overview(string $category)
    {
        $productCategory = $category;
        $products = [
            'Appel',
            'Beer',
            'C',
            'Draaitol',
            'Eten',
            'Fornuis',
            'Goud',
            'Huis',
        ];

        //
        $sizes = [
            'S',
            'M',
            'L',
            'XL'
        ];

        return view('orders.overview', [
            'productCategory' => $productCategory,
            'products' => $products,
            'sizes' => $sizes
        ]);
    }
}
