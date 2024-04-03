<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index(){
        return view('track_orders.trackOrders', ['orders' => Order::all()]);
    }

    public function details(int $id){
        $order2 = Order::find($id);
        return view('track_orders.orderDetails', ['order' => $order2]);
    }
}
