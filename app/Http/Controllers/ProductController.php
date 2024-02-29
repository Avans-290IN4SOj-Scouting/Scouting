<?php

namespace App\Http\Controllers;

class ProductController extends Controller
{
    public function productOverview()
    {
        ## get products from database here (using transaction?)
        ## $products = Product::all();
        return view('Products.Overview', ['products' => $products]);
    }

    public function addProduct()
    {
        return view('Products.Add');
    }

    public function storeProduct()
    {
        $product = new Product(request('name'), request('category'), request('picture'));
        $product->setPriceForSize(request('priceForSize'));
        $product->setGroups(request('groups'));
        ## db insert product here (using transaction?)

        return redirect('/products');
    }

    public function editProduct($productId)
    {
        ## $product = Product::find($productId);
        return view('Products.Edit', ['product' => $product]);
    }
}
