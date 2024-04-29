<?php

namespace App\Http\Controllers;

use App\Enum\DeliveryStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{
    public function orderDetails()
    {
        // hardcoded value to test
        $orderId = 1;

        $order = Order::where('id', $orderId)->first();
        $order->order_date = new \DateTime($order->order_date);
        $order->status = DeliveryStatus::localisedValue($order->status);

        $orderLines = OrderLine::with('product')->where('order_id', $orderId)->get();

        $totalPrice = 0;

        foreach ($orderLines as $orderLine) {
            $totalPrice += $orderLine->product_price * $orderLine->amount;
        }

        return view('orders.orderdetails', ['order' => $order, 'orderLines' => $orderLines, 'totalPrice' => $totalPrice]);
    }
}
