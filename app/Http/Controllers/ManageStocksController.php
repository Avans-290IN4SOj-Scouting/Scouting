<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ManageStocksController extends Controller
{
    public function index()
    {
        $products = Product::with(['productType', 'productSizes'])->get();

        return view("admin.stocks", ['products' => $products]);
    }

    public function update(Request $request, $id)
    {
        foreach ($request->all() as $key => $value) {

            if (Str::startsWith($key, 'size-')) {

                Stock::create([
                    'amount' => $value,
                    'product_id' => $id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully');
    }


}
