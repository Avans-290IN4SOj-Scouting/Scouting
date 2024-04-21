<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ManageProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        //only for frontend
        $total = 3;

        return view("admin.products", ['products' => $products, 'total' => $total]);
    }

}
