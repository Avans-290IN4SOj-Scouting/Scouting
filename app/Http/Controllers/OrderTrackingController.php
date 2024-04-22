<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderTrackingController extends Controller
{
    public function index(){
        $orders = Order::with('orderLine', 'orderStatus')->where('user_id', auth()->id())->get();

        //Get most expensive orderline for each order and add associated product to Associative array
        $mostExpensiveProductByOrder = $orders->mapWithKeys(function ($order) {
            return [$order->id => $order->getMostExpensiveOrderLine()->product];
        });
        
        return view('track_orders.trackOrders', ['orders' => $orders, 'mostExpensiveProductsByOrder' => $mostExpensiveProductByOrder]);
    }

    public function details(Order $order){
        //calculate total cost of the order
        $total = $order->getTotalOrderCost();

        return view('track_orders.orderDetails', ['order' => $order, 'total' => $total]);
    }
}
