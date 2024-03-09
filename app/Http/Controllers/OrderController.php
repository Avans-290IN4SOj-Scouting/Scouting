<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\ProductSize;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\error;

class OrderController extends Controller
{
    // GET
    public function overview(string $category, string $size)
    {
        $productCategory = ucfirst($category);
        $products = Product::join('product_product_size', 'products.id', '=', 'product_product_size.product_id')
            ->join('product_sizes', 'product_sizes.id', '=', 'product_product_size.product_size_id')
            ->where('product_sizes.size', '=', $size)
            ->select('products.*', 'product_product_size.*', 'product_sizes.*')
            ->get();

        $sizes = ProductSize::all();

        return view('orders.overview', [
            'sizes' => $sizes,
            'sizeSelected' => $size,
            'productCategory' => $productCategory,
            'products' => $products
        ]);
    }

    public function product(string $id, string $size)
    {
        $product = Product::join('product_product_size', 'products.id', '=', 'product_product_size.product_id')
        ->join('product_sizes', 'product_sizes.id', '=', 'product_product_size.product_size_id')
        ->where('products.id', '=', $id)
        ->where('product_sizes.size', '=', $size)
        ->select('products.*', 'product_product_size.*', 'product_sizes.*')
        ->first();

        if ($product === null) {
            return redirect()->route('orders.overview');
        }

        $sizes = ProductSize::all();

        return view('orders.product', [
            'sizes' => $sizes,
            'sizeSelected' => $size,
            'productCategory' => 'Not Implemented!',
            'product' => $product
        ]);
    }

    public function order()
    {
        $order = 1;
        $groups = Group::all();

        $products = ShoppingCartController::getShoppingCartProducts();
        $prices = ShoppingCartController::getPrices($products);

        return view('orders.order', [
            'order' => $order,
            'prices' => $prices,
            'groups' => $groups,
            'products' => $products
        ]);
    }

    // POST
    public function completeOrder(Request $request)
    {
        $request->flash('form_data', $request->all());

        $validated = $request->validate([
            'email' => 'required|max:64',
            'lid-name' => 'required|max:32',
            'postalCode' => 'regex:/^[0-9]{4} ?[a-zA-Z]{2}$/',
            'houseNumber' => 'required|integer|max:32',
            'houseNumberAddition' => 'max:8',
            'streetname' => 'required|max:32',
            'cityName' => 'required|max:32',
            'group' => 'required|integer'
        ]);

        // Create Order
        $order = new Order();
        $order->order_date = now();
        $order->email = $request->input('email');
        $order->lid_name = $request->input('lid-name');
        $order->postal_code = $request->input('postalCode');
        $order->house_number = $request->input('houseNumber');
        $order->house_number_addition = $request->input('houseNumberAddition');
        $order->streetname = $request->input('streetname');
        $order->cityname = $request->input('cityName');
        $order->group_id = $request->input('group');
        $order->save();

        DB::beginTransaction();
        try {
            $products = ShoppingCartController::getShoppingCartProducts(); // Returns a Product[];

            foreach ($products as $product)
            {
                // Create an orderline
                $orderLine = new OrderLine();
                $orderLine->order_id = $order->id;
                $orderLine->product_id = $product->product_id;
                $orderLine->amount = $product->amount;
                $orderLine->product_price = $product->price;
                $orderLine->product_size = $product->size;

                $orderLine->save();
            }

            // Below
            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollBack();
            $order->delete();

            return redirect()->route('orders.order')->with('error', '__(\'orders.completed-error\')');
        }

        ShoppingCartController::clearShoppingCart();
        return redirect()->route('orders.completed')->with('success', '__(\'orders.completed-success\')');
    }

    public function completedOrder() {
        return view('orders.complete', [

        ]);
    }
}
