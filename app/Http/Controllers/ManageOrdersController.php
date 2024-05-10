<?php

namespace App\Http\Controllers;

use App\Enum\DeliveryStatus;
use App\Models\Order;
use App\Models\OrderStatus;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ManageOrdersController extends Controller
{
    public function index()
    {
        $orders = Order::query();

        if (Auth::user()->hasRole('teamleader'))
        {
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
        if ($order === null)
        {
            return redirect()->route('manage.orders.index')
                ->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-orders/order.order-doesnt-exist')
                ]);
        }

        return view('admin.order-details', [
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

        $order->status = DeliveryStatus::Cancelled;
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
        $status = $request->input('filter');;

        $orders = Order::query();

        if (Auth::user()->hasRole('teamleader'))
        {
            $orders = $orders->whereIn('group_id', $this->getUserRoles());
        }

        $status = DeliveryStatus::hasStatus($status) ? $status : null;

        // Check for Email
        if (!empty($search))
        {
            $orders = $orders->whereHas('user', function ($query) use ($search) {
                $query->where('email', 'like', "%$search%");
            });
        }

        // Check for Status
        if ($status !== null)
        {
            $orders = $orders->where('status', $status);
        }

        // Check for date
        $dateFromString = $request->input('date-from-filter');
        $dateTillString = $request->input('date-till-filter');
        try
        {
            // Check is from is empty ...
            if (!empty($dateFromString))
            {
                /// ... if not set it
                $dateFrom = Carbon::createFromFormat('Y-m-d', $dateFromString)->toDateTimeString();

                // if till is empty set it to the next day
                if (empty($dateTillString))
                {
                    $dateTill = Carbon::now()->addDay(1);
                    $dateTillString = $dateTill->format('Y-m-d');
                }
                else
                {
                    $dateTill = Carbon::createFromFormat('Y-m-d', $dateTillString)->toDateTimeString();
                }
            }
            else
            {
                // If it is empty and till is empty, do nothing because both are empty
                if (!empty($dateTillString))
                {
                    // if till is not empty, set from to ???
                    $dateTill = Carbon::createFromFormat('Y-m-d', $dateTillString)->toDateTimeString();
                    $dateFrom = Carbon::createFromTimestamp(0);
                    $dateFromString = $dateFrom->format('Y-m-d');
                }
            }

            $orders = $orders->whereBetween('order_date', [$dateFrom, $dateTill]);
        }
        catch (Exception $e) { }

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

    private function getUserRoles() {
        return Auth::user()->roles->pluck('group_id')->whereNotNull()->toArray();
    }
}
