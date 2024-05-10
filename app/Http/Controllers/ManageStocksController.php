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
        $products = Product::with(['productType', 'productSizes', 'stocks'])->get();

        return view("admin.stocks", ['products' => $products]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'size-')) {
                // The size is extracted from the key by removing 'size-' from the start
                $size = Str::after($key, 'size-');
                $size = strtoupper(preg_replace("/[^A-Za-z]/", '', $size));

                // Find the productSize for the current size
                $productSize = $product->productSizes()->where('size', $size)->first();

                if ($productSize) {
                    // Find or create a stock for the current productSize
                    Stock::updateOrCreate(
                        ['product_id' => $product->id, 'product_size_id' => $productSize->id], // These fields are used to find an existing record
                        ['amount' => $value] // These are the values used to update or create a record
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully');
    }


}
