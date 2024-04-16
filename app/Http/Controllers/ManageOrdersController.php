<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Exception;
use Illuminate\Http\Request;

class ManageOrdersController extends Controller
{
    public function index()
    {
        // $orders = $this->getAllOrders()->sortable()->paginate(10);
        $orders = $this->getAllOrders();

        return view('admin.orders', [
            'orders' => $orders,
            'search' => null,
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
        $orders = $this->getAllOrders()->first();

        // dd($orders);

        // $filter = $request->input('filter');
        // if ($filter)
        // {
        //     try
        //     {
        //         $orders = $orders->whereHas
        //     }
        //     catch (Exception $e)
        //     {
        //         // TODO: change to nice toast
        //         dd('1');
        //     }
        // }

        return view('admin.orders', [
            'orders' => $orders,
            'search' => null,
            'allstatusses' => $this->getAllStatusses(),
            'selected' => null,
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
