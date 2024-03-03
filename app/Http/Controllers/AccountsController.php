<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Lang;

class AccountsController extends Controller
{
    public function index()
    {
        $accounts = User::with("roles")->get();

        return view("admin.accounts", ["accounts" => $accounts]);
    }

    public function updateRoles(Request $request)
    {
        $accounts = json_decode($request->input("userRoles"), true);

        foreach ($accounts as $account) {
            $user = User::where("email", $account["email"])->first();

            if ($user && isset($account["newRole"])) {

                if ($user->hasRole($account["oldRole"])) {
                    $oldRole = Role::where("name", $account["oldRole"])->first();
                    $user->removeRole($oldRole);
                }

                $translatedRole = Lang::has("accounts." . $account["newRole"])
                    ? Lang::get("accounts." . $account["newRole"])
                    : $account["newRole"];

                $role = Role::firstOrCreate(["name" => $translatedRole]);

                $user->assignRole($role);
            }
        }

        $accounts = User::with("roles")->get();

        return view("admin.accounts", ["accounts" => $accounts]);
    }
}
