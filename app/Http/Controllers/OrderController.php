<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\ProductSize;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;

class OrderController extends Controller
{
    // GET
    public function overview(string $category)
    {
        $productCategory = $category;
        $products = Product::all();

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
            $orderlines = [];
            $products = ShoppingCartController::getShoppingCartProducts(); // Returns a Product[];

            foreach ($products as $product)
            {
                // Create an orderline
                $orderLine = new OrderLine();
                $orderLine->order_id = $order->id;
                $orderLine->product_id = $product->id;
                $orderLine->amount = $product->amount;
                dd($product->productSizes);
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
