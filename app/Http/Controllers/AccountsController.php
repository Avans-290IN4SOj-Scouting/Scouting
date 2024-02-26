<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        // test data; remove when done
        $accounts = [];

        for ($i = 1; $i <= 50; $i++) {
            $accounts[] = ['email' => "gebruiker{$i}@example.com", 'role' => 'gebruiker'];
        }

        for ($i = 1; $i <= 10; $i++) {
            $accounts[] = ['email' => "teamleider{$i}@example.com", 'role' => 'teamleider'];
        }

        $accounts[] = ['email' => 'admin1@example.com', 'role' => 'admin'];
        $accounts[] = ['email' => 'admin2@example.com', 'role' => 'admin'];

        return view("admin.accounts", ["accounts" => $accounts]);
    }
}
