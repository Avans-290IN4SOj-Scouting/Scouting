<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AccountsController extends Controller
{
    public function index()
    {
        $accounts = User::with("roles")->get();

        return view("admin.accounts", ["accounts" => $accounts]);
    }

    public function updateRoles(Request $request)
    {
        $accounts = $request->input("accounts");

        foreach ($accounts as $account) {
            $email = $account["email"];
            $role = $account["role"];
        }
    }
}
