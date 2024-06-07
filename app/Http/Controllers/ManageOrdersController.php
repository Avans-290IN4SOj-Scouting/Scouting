<?php

namespace App\Http\Controllers;

use App\Enum\DeliveryStatus;
use App\Http\Requests\UpdateProductPriceRequest;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\ProductType;
use App\Services\GmailService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use ReflectionException;

class ManageOrdersController extends Controller
{
    public function __construct(
        protected GmailService $gmailService
    )
    {
    }

    public function index()
    {
        $orders = Order::query();

        if (Auth::user()->hasRole('teamleader')) {
            $orders = $orders->whereIn('group_id', $this->getUserRoles());
        }

        $orders = $orders->sortable()->paginate(10);

        return view('admin.orders', [
            'orders' => $orders,
            'search' => null,
            'dateFrom' => null,
            'dateTill' => null,
            'allstatusses' => DeliveryStatus::localised(),
            'selected' => null,
        ]);
    }

    public function orderDetails(string $id)
    {
        $order = Order::find($id);
        if ($order === null) {
            return redirect()->route('manage.orders.index')
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-orders/order.order-doesnt-exist')
                ]);
        }

        $products = $this->getAllProducts();

        return view('admin.order-details', [
            'order' => $order,
            'products' => $products,
        ]);
    }

    private function getAllProducts()
    {
        $products = Product::query()
            ->join('product_product_type', 'product_product_type.product_id', '=', 'products.id')
            ->join('product_types', 'product_types.id', '=', 'product_product_type.product_type_id')
            ->join('product_product_size', 'product_product_size.product_id', '=', 'products.id')
            ->join('product_sizes', 'product_sizes.id', '=', 'product_product_size.product_size_id')
            ->select('products.*', 'product_types.type as type', 'product_sizes.size as size', 'product_product_size.price as price')
            ->orderBy('products.name')
            ->orderBy('product_types.type')
            ->get();

        $products->each(function ($product, $index) {
            $product->row_number = $index + 1;
        });

        return $products;
    }

    /**
     * @throws ReflectionException
     */
    public function updateOrderStatus(Request $request, string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->route('manage.orders.index')
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-orders/order.order-doesnt-exist')
                ]);
        }

        $status = $request->input('status');
        $order->status = $status;

        $logoPath = public_path('images/scouting/AZG_Scouting_logo_slogan_compact_RGB.png');
        $emailContent = View::make('orders.emails.orderstatus_changed', ['order' => $order, 'productTypes' => ProductType::all()])->render();
        $this->gmailService->sendMail($order->user->email, __('email.orderstatus-changed.subject'), $emailContent, $logoPath);

        $delocalizedStatus = DeliveryStatus::delocalised($status);
        $order->status = $delocalizedStatus;

        if (!$order->save()) {
            return redirect()->back()->with([
                'toast-type' => 'error',
                'toast-message' => __('toast/messages.error-order-status-not-updated')
            ]);
        }

        return redirect()->back()->with([
            'toast-type' => 'success',
            'toast-message' => __('toast/messages.success-order-status-update')
        ]);
    }

    public function updateProductPrice(UpdateProductPriceRequest $request, string $id)
    {
        $orderline = OrderLine::find($id);

        if ($orderline === null) {
            return redirect()->back()
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('toast/messages.product-update-fail')
                ]);
        }

        $orderline->product_price = $request->input('product-price');
        $orderline->save();

        return redirect()->back()
            ->with([
                'toast-type' => 'success',
                'toast-message' => __('toast/messages.product-update-success')
            ]);
    }

    public function cancelOrder(string $id)
    {
        $order = Order::find($id);
        if ($order === null) {
            return redirect()->route('manage.orders.index')
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-orders/order.order-doesnt-exist')
                ]);
        }

        $order->status = DeliveryStatus::Cancelled;
        $order->save();

        return redirect()->route('manage.orders.index')
            ->with([
                'toast-type' => 'success',
                'toast-message' => __('manage-orders/order.cancel-order-success')
            ]);
    }

    public function deleteOrderLine(Request $request, string $id)
    {
        $validated = $request->validate;

        $orderLine = OrderLine::find($id);
        if ($orderLine === null) {
            return redirect()->back()
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-orders/order.product-remove-fail')
                ]);
        }

        $orderLine->delete();

        return redirect()->back()
            ->with([
                'toast-type' => 'success',
                'toast-message' => __('manage-orders/order.product-removed')
            ]);
    }

    public function addProduct(Request $request, string $id)
    {
        $validated = $request->validate([
            'product-select' => 'required',
        ]);

        $products = $this->getAllProducts();
        $product = $products->where('row_number', $validated['product-select'])->first();

        $order = Order::find($id);
        if ($order === null) {
            return redirect()->back()
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-orders/order.order-doesnt-exist')
                ]);
        }

        if ($product === null) {
            return redirect()->back()
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-orders/order.product-add-fail')
                ]);
        }

        $orderLine = OrderLine::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'amount' => 1,
            'product_price' => $product->price,
            'product_size' => $product->size,
            'product_type_id' => ProductType::where('type', $product->type)->first()->id,
            'product_image_path' => Product::find($product->id)->first()->image_path,
        ]);

        if ($orderLine === null) {
            return redirect()->back()
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-orders/order.product-add-fail')
                ]);
        }

        return redirect()->back()
            ->with([
                'toast-type' => 'success',
                'toast-message' => __('manage-orders/order.product-add-success')
            ]);
    }

    public function filter(Request $request)
    {
        $search = $request->input('q');
        $status = $request->input('filter');;

        $orders = Order::query();

        if (Auth::user()->hasRole('teamleader')) {
            $orders = $orders->whereIn('group_id', $this->getUserRoles());
        }

        $status = DeliveryStatus::hasStatus($status) ? $status : null;

        // Check for Email
        if (!empty($search)) {
            $orders = $orders->whereHas('user', function ($query) use ($search) {
                $query->where('email', 'like', "%$search%");
            });
        }

        // Check for Status
        if ($status !== null) {
            $orders = $orders->where('status', $status);
        }

        // Check for date
        $dateFromString = $request->input('date-from-filter');
        $dateTillString = $request->input('date-till-filter');
        try {
            // Check is from is empty ...
            if (!empty($dateFromString)) {
                /// ... if not set it
                $dateFrom = Carbon::createFromFormat('Y-m-d', $dateFromString)->toDateTimeString();

                // if till is empty set it to the next day
                if (empty($dateTillString)) {
                    $dateTill = Carbon::now()->addDay(1);
                    $dateTillString = $dateTill->format('Y-m-d');
                } else {
                    $dateTill = Carbon::createFromFormat('Y-m-d', $dateTillString)->toDateTimeString();
                }
            } else {
                // If it is empty and till is empty, do nothing because both are empty
                if (!empty($dateTillString)) {
                    // if till is not empty, set from to ???
                    $dateTill = Carbon::createFromFormat('Y-m-d', $dateTillString)->toDateTimeString();
                    $dateFrom = Carbon::createFromTimestamp(0);
                    $dateFromString = $dateFrom->format('Y-m-d');
                }
            }

            $orders = $orders->whereBetween('order_date', [$dateFrom, $dateTill]);
        } catch (Exception $e) {
        }

        $orders = $orders->sortable()->paginate(10);

        return view('admin.orders', [
            'orders' => $orders,
            'search' => $search,
            'dateFrom' => $dateFromString,
            'dateTill' => $dateTillString,
            'allstatusses' => DeliveryStatus::localised(),
            'selected' => $status,
        ]);
    }

    private function getUserRoles()
    {
        return Auth::user()->roles->pluck('group_id')->whereNotNull()->toArray();
    }
}
