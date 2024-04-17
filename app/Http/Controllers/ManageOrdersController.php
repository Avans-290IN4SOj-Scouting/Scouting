<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class ManageOrdersController extends Controller
{
    public function index()
    {
        $orders = Order::query()->sortable()->paginate(10);

        return view('admin.orders', [
            'orders' => $orders,
            'search' => null,
            'dateFrom' => null,
            'dateTill' => null,
            'allstatusses' => $this->getAllStatusses(),
            'selected' => null,
        ]);
    }

    public function order(string $id)
    {
        $order = Order::find($id);
        if ($order === null)
        {
            return redirect()->route('manage.orders.index')
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-orders/order.order-doesnt-exist')
                ]);
        }

        return view('admin.order', [
            'order' => $order,
        ]);
    }

    public function cancelOrder(string $id)
    {
        $order = Order::find($id);
        if ($order === null)
        {
            return redirect()->route('manage.orders.index')
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-orders/order.order-doesnt-exist')
                ]);
        }

        $order->order_status_id = OrderStatus::where('status', 'cancelled')->first()->id;
        $order->save();

        return redirect()->route('manage.orders.index')
            ->with([
                'toast-type' => 'success',
                'toast-message' => __('manage-orders/order.cancel-order-success')
            ]);
    }

    public function filter(Request $request)
    {
        $search = $request->input('q');
        $status = $request->input('filter');

        $orderStatus = OrderStatus::find($status);

        $orders = $this->getAllOrders();

        // Check for Email
        if (!empty($search))
        {
            $orders = Order::whereHas('user', function ($query) use ($search) {
                $query->where('email', 'like', "%$search%");
            })->get();
        }

        // Check for Status
        if ($orderStatus !== null)
        {
            $orders = $orders->where('order_status_id', $orderStatus->id);
        }

        // Check for date
        $dateFromString = $request->input('date-from-filter');
        $dateTillString = $request->input('date-till-filter');
        try
        {
            $dateFrom = Carbon::createFromFormat('Y-m-d', $dateFromString)->toDateTimeString();
            $dateTill = Carbon::createFromFormat('Y-m-d', $dateTillString)->toDateTimeString();

            $orders = $orders->whereBetween('created_at', [$dateFrom, $dateTill]);
        }
        catch (InvalidFormatException $e) { }

        return view('admin.orders', [
            'orders' => $orders,
            'search' => $search,
            'dateFrom' => $dateFromString,
            'dateTill' => $dateTillString,
            'allstatusses' => $this->getAllStatusses(),
            'selected' => $orderStatus,
        ]);
    }

    private function getAllOrders()
    {
        return Order::all();
    }

    private function getAllStatusses()
    {
        return OrderStatus::all();
    }
}
