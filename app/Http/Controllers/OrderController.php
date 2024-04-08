<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Services\ShoppingCartService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;

class OrderController extends Controller
{
    public function __construct(
        protected ShoppingCartService $shoppingCartService
    ) { }

    // GET
    public function index()
    {
        $groups = Group::all();

        return view('orders.groups', [
            'groups' => $groups
        ]);
    }

    public function overview(string $category = null)
    {
        // Check if URL has matching Group
        $group = Group::where('name', $category)->first();
        if ($group === null)
        {
            abort(404);
        }

        // Get all Products from obtained Group
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
            'products' => $products,
            'group' => $group
        ]);
    }

    public function product(string $name = null, string $groupName = null)
    {
        // Check if URL contains a valid Product and Group
        $productFromName = Product::where('name', $name)->first();
        $groupFromName = Group::where('name', $groupName)->first();
        if ($productFromName === null || $groupFromName === null)
        {
            return redirect()->route('orders.overview');
        }

        // Get product from obtained Product, and get default size
        $product = Product::with(['productSizes' => function ($query) use ($groupFromName) {
                $query->where('product_size_id', '=', $groupFromName->size_id);
            }])
            ->where('id', '=', $productFromName->id)
            ->first();

        if ($product === null) {
            return redirect()->route('orders.overview');
        }

        // Get Pivot table values
        $productSizes = $productFromName->productSizes;

        return view('orders.product', [
            'group' => $groupFromName,
            'product' => $product,
            'productSizes' => $productSizes
        ]);
    }

    public function order()
    {
        $groups = Group::all();

        $products = $this->shoppingCartService->getShoppingCartProducts();
        $prices = $this->shoppingCartService->getPrices($products);

        return view('orders.order', [
            'prices' => $prices,
            'groups' => $groups,
            'products' => $products
        ]);
    }

    // POST
    public function completeOrder(Request $request)
    {
        // Validate form data
        $request->flash('form_data', $request->all());
        $validated = $request->validate([
            'lid-name' => 'required|max:32',
            'scouting-group' => 'required|integer'
        ]);

        DB::beginTransaction();
        $order = new Order();
        try
        {
            // Create and save order to obtain ID for OrderLine(s)
            $order->order_date = now();
            $order->lid_name = $request->input('lid-name');
            $order->group_id = $request->input('scouting-group');
            $order->save();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return redirect()->route('orders.checkout.order')->with([
                'error', '__(\'orders.completed-error\')',
                'toast-type' => 'error',
                'toast-message' => __('orders.completed-error'),
            ]);
        }

        try {
            $products = $this->shoppingCartService->getShoppingCartProducts(); // Returns a Product[];
            if (count($products) == 0)
            {
                DB::rollBack();
                $this->shoppingCartService->clearShoppingCart();

                return redirect()->route('orders.checkout.order')->with([
                    'error', '__(\'orders.completed-error\')',
                    'toast-type' => 'error',
                    'toast-message' => __('toast.order-no-products'),
                ]);
            }

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

            return redirect()->route('orders.checkout.order')->with([
                'error', '__(\'orders.completed-error\')',
                'toast-type' => 'error',
                'toast-message' => __('toast.order-no-products'),
            ]);
        }

        $this->shoppingCartService->clearShoppingCart();
        return redirect()->route('orders.checkout.completed')
            ->with('success', '__(\'orders.completed-success\')');
    }

    public function completedOrder() {
        return view('orders.complete');
    }
}
