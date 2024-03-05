<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\ProductProductSize;
use App\Models\ProductSize;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use function Laravel\Prompts\error;

class OrderController extends Controller
{
    // GET
    public function overview(string $category, string $size)
    {
        $productCategory = $category;

        // I'm leaving this here, so leave it :)
        // This how to access pivot table data
        // $query->where('product_product_size.price', '>', 11.11);
        // $products = Product::whereHas('productSizes', function (Builder $query) use ($size) {
        //     $query->where('size', '=', $size);
        // })->get();

        $products = Product::join('product_product_size', 'products.id', '=', 'product_product_size.product_id')
            ->join('product_sizes', 'product_sizes.id', '=', 'product_product_size.product_size_id')
            ->where('product_sizes.size', '=', $size)
            ->select('products.*', 'product_product_size.*')
            ->get();

        $sizes = ProductSize::all();

        return view('orders.overview', [
            'sizes' => $sizes,
            'productCategory' => $productCategory,
            'products' => $products
        ]);
    }

    public function product(string $id)
    {
        $product = Product::find($id);
        if ($product === null) {
            return redirect()->route('orders.overview');
        }

        $sizes = ProductSize::all();

        return view('orders.product', [
            'sizes' => $sizes,
            'productCategory' => 'Not Implemented!',
            'product' => $product
        ]);
    }

    public function order()
    {
        $order = 1;
        $groups = OrderController::getGroups();

        return view('orders.order', [
            'order' => $order,
            'groups' => $groups
        ]);
    }

    // POST
    public function completeOrder(Request $request)
    {

        return $products = ShoppingCartController::getShoppingCartProducts();
        // $request->session()->flash('form_data', $request->all());

        // $validated = $request->validate([
        //     'email' => 'required|max:64',
        //     'lid-naam' => 'required|max:32',
        //     'postalCode' => 'required|max:32',
        //     'houseNumber' => 'required|max:32',
        //     'houseNumberAddition' => 'max:8',
        //     'streetname' => 'required|max:32',
        //     'cityName' => 'required|max:32',
        // ]);

        // Create Order
        $order = new Order();
        $order->order_date = now();
        $order->save();

        DB::beginTransaction();
        try {
            $products = ShoppingCartController::getShoppingCartProducts(); // Returns a Product[];

            foreach ($products as $product)
            {
                // Create an orderline
                $orderLine = new OrderLine();
                $orderLine->order_id = $order->id;
                $orderLine->product_id = $product->id;
                $orderLine->amount = $product->amount;
                $orderLine->product_price = 12.34;

                $orderLine->save();
            }

            // Below
            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollBack();
            $order->delete();
            dd("ERROR", $e);
        }
    }

    public static function getGroups()
    {
        return [
            'Bevers',
            'Bevertjes',
            'Beverinos',
            'Bee-heel-vers'
        ];
    }
}
