<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    // POST
    public function insert(string $id)
    {
        dd('Cart received: ' . $id);

        // TODO: add logic for shopping cart
    }
}
