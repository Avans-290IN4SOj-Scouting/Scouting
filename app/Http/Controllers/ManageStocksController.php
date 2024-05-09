<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ManageStocksController extends Controller
{
    public function index()
    {
        $products = Product::with(['productType', 'productSizes'])->get();

        return view("admin.stocks", ['products' => $products]);
    }
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        // Validate the request data
        $validated = $request->validate([
            'productSizes' => 'required|array',
            'productSizes.*' => 'integer|min:0'
        ]);

        foreach ($validated['productSizes'] as $sizeId => $quantity) {
            $stock = $product->stocks()->where('size_id', $sizeId)->first();

            if ($stock) {
                // Update existing stock record
                $stock->update(['quantity' => $quantity]);
            } else {
                // Create new stock record
                $product->stocks()->create([
                    'size_id' => $sizeId,
                    'quantity' => $quantity
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully');
    }


}
