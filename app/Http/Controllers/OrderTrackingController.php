<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index(){
        return view('track_orders.trackOrders');
    }
}
