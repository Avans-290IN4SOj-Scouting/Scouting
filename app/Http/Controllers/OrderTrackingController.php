<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index(){
        return view('track_orders.trackOrders', ['orders' => Order::where('user_id', auth()->id())->get()]);
    }

    public function details(int $id){
        return view('track_orders.orderDetails', ['order' => Order::with('orderline')->where('id', $id)->first()]);
    }
}
