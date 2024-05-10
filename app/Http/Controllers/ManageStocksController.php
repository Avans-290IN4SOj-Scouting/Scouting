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
                $size = Str::after($key, 'size-');
                $size = strtoupper(preg_replace("/[^A-Za-z]/", '', $size));

                $productSize = $product->productSizes()->where('size', $size)->first();

                if ($productSize) {
                    Stock::updateOrCreate(
                        ['product_id' => $product->id, 'product_size_id' => $productSize->id],
                        ['amount' => $value]
                    );
                }
            }
        }

        return redirect()->back();
    }

    public function delete()
    {
        Stock::query()->delete();

        return redirect()->route('manage.stocks')
            ->with('success', 'All stocks have been deleted.');
    }

}
