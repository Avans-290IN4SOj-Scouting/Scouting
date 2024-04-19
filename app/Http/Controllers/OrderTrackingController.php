<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderTrackingController extends Controller
{
    public function index(){
        $orders = Order::with('orderLine', 'orderStatus')->where('user_id', auth()->id())->get();

        //Calculate most expensive product for each order and add to Associative array
        $mostExpensiveProductsByOrder = [];

        foreach ($orders as $order) {
            $mostExpensiveProduct = null;

            foreach ($order->orderLine as $orderLine) {
                // If no product is set or the current product's price is higher than the one stored
                if ($mostExpensiveProduct === null || $mostExpensiveProduct->price < $orderLine->product->price) {
                    $mostExpensiveProduct = $orderLine->product;
                }
            }
            // Only add to the result if there's a product (in case there are orders with no order lines)
            if ($mostExpensiveProduct !== null) {
                $mostExpensiveProductsByOrder[$order->id] = $mostExpensiveProduct;
            }
        }
        return view('track_orders.trackOrders', ['orders' => $orders, 'mostExpensiveProductsByOrder' => $mostExpensiveProductsByOrder]);
    }

    public function details(Order $order){


        //calculate total cost of the order
        $total = 0;
        foreach ($order->orderLine as $orderLine) {
            $total += $orderLine->product_price * $orderLine->amount;
        }

        return view('track_orders.orderDetails', ['order' => $order, 'total' => $total]);
    }
}
