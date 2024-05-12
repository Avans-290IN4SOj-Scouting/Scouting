<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StocksController extends Controller
{
    public function index()
    {
        $products = Product::with(['productType', 'productSizes', 'stocks'])->get();

        return view('admin.stocks', ['products' => $products]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'size-') && $value < 0) {
                return redirect()->back()->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-stocks/stocks.invalid_amount')
                ]);
            }
        }

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

        return redirect()->back()->with([
            'toast-type' => 'success',
            'toast-message' => __('manage-stocks/stocks.update_inventory_success')
        ]);
    }

    public function destroy()
    {
        Stock::query()->delete();

        return redirect()->back()->with([
            'toast-type' => 'success',
            'toast-message' => __('manage-stocks/stocks.empty_inventory_success')
        ]);
    }

}
