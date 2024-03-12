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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\error;

class OrderController extends Controller
{
    // GET
    public function index()
    {
        $groups = Group::all();

        return view('orders.groups', [
            'groups' => $groups
        ]);
    }

    public function overview(string $category)
    {
        $group = Group::where('name', $category)->first();
        if ($group === null)
        {
            return redirect()->route('home');
        }

        $productCategory = ucfirst($category);

        $products = Product::join('product_group', 'products.id', '=', 'product_group.product_id')
            ->join('groups', 'product_group.group_id', '=', 'groups.id')
            ->join('product_sizes', 'groups.size_id', '=', 'product_sizes.id')
            ->join('product_product_size', function ($join) {
                $join->on('products.id', '=', 'product_product_size.product_id')
                    ->on('product_sizes.id', '=', 'product_product_size.product_size_id');
            })
            ->where('groups.id', '=', $group->id)
            ->select('products.*', 'product_product_size.*')
            ->get();

        return view('orders.overview', [
            'productCategory' => $productCategory,
            'products' => $products,
            'group' => $group
        ]);
    }

    public function product(string $name, string $groupName)
    {
        $productFromName = Product::where('name', $name)->first();
        $groupFromName = Group::where('name', $groupName)->first();
        if ($productFromName === null || $groupFromName === null)
        {
            return redirect()->route('orders.overview');
        }

        $product = Product::join('product_product_size', 'products.id', '=', 'product_product_size.product_id')
        ->join('product_sizes', 'product_sizes.id', '=', 'product_product_size.product_size_id')
        ->where('products.id', '=', $productFromName->id)
        ->where('product_sizes.id', '=', $groupFromName->id)
        ->select('products.*', 'product_product_size.*', 'product_sizes.*')
        ->first();

        if ($product === null) {
            return redirect()->route('orders.overview');
        }

        $productSizes = $product->productSizes;

        return view('orders.product', [
            'group' => $groupFromName,
            'product' => $product,
            'sizeSelected' => $groupFromName->name,
            'productSizes' => $productSizes
        ]);
    }

    public function order()
    {
        $groups = Group::all();

        $products = ShoppingCartController::getShoppingCartProducts();
        $prices = ShoppingCartController::getPrices($products);

        return view('orders.order', [
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
            'lid-name' => 'required|max:32',
            'group' => 'required|integer'
        ]);

        // Create Order
        DB::beginTransaction();
        $order = new Order();
        try
        {
            $order->order_date = now();
            $order->lid_name = $request->input('lid-name');
            $order->group_id = $request->input('group');
            $order->save();
        }
        catch (Exception $e)
        {
            dd($e);
            DB::rollBack();
            $order->delete();

            return redirect()->route('orders.order')->with('error', '__(\'orders.completed-error\')');
        }

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
