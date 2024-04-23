<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserOrdersController extends Controller
{
    public function orderDetails() {
        return view('orders.orderdetails');
    }
}
