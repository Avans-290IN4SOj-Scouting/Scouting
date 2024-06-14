<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockUpdateRequest;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Stock;
use Illuminate\Support\Str;

class StocksController extends Controller
{
    public function index()
    {
//        $products = Product::with('productSizes', 'stocks')
//            ->join('product_types', 'product_types.id', '=', 'products.type_id')
//            ->join('product_varieties', 'product_varieties.id', '=', 'products.variety_id')
//            ->get();

        $products = Product::with(['productSizes', 'type', 'variety', 'stocks'])->get();

//        dd($products);

        return view('admin.stocks', ['products' => $products]);
    }

    public function update(StockUpdateRequest $stockUpdateRequest, $productId, $productTypeId)
    {
        $product = Product::findOrFail($productId);
        $productType = ProductType::findOrFail($productTypeId);

        foreach ($stockUpdateRequest->all() as $key => $value) {
            if (Str::startsWith($key, 'size-')) {
                $size = Str::after($key, 'size-');
                $size = explode('-', $size)[0];

                $productSize = $product->productSizes()->where('size', $size)->first();

                if ($productSize) {
                    $stock = Stock::where([
                        'product_id' => $product->id,
                        'product_type_id' => $productType->id,
                        'product_size_id' => $productSize->id
                    ])->first();

                    if ($stock || $value > 0) {
                        Stock::updateOrCreate(
                            ['product_id' => $product->id, 'product_type_id' => $productType->id, 'product_size_id' => $productSize->id],
                            ['amount' => $value]
                        );
                    }
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
