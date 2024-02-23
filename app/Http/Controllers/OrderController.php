<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private function getSizes()
    {
        return [
            'S',
            'M',
            'L',
            'XL'
        ];
    }

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

        return view('orders.overview', [
            'sizes' => $this->getSizes(),
            'productCategory' => $productCategory,
            'products' => $products
        ]);
    }

    public function product(string $id)
    {
        $product = new Product;
        $product->name = $id;
        $product->price = '12,34';
        $product->salePrice = '11,22';
        $product->imageUri = 'https://placehold.co/400x400';

        return view('orders.product', [
            'sizes' => $this->getSizes(),
            'productCategory' => 'Not Implemented!',
            'product' => $product
        ]);
    }
}
