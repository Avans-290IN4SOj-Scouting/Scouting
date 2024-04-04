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
        try {
            $accounts = User::with(["roles" => function ($query) {
                $query->where('name', '!=', 'teamleader');
            }])->get();

            $roles = Role::where('name', '!=', 'teamleader')->get();

            return view("admin.accounts", ["accounts" => $accounts, "roles" => $roles]);
        } catch (\Exception $e) {
            return redirect()->route('home')->with([
                'toast-type' => 'error',
                'toast-message' => __('toast.error-account-loading'),
            ]);
        }
    }

    public function updateRoles(Request $request)
    {
        try {
            $accounts = json_decode($request->input("userRoles"), true);

            $teamRoles = Role::where("name", "LIKE", "team_%")->pluck("name")->toArray();

            foreach ($accounts as $account) {
                $user = User::where("email", $account["email"])->first();

                if ($user && isset($account["newRoles"])) {

                    if ($user->hasRole($account["oldRoles"])) {
                        $user->roles()->detach();
                    }

                    $teamleaderRole = Role::where("name", "teamleader")->first();
                    foreach ($account["newRoles"] as $newRole) {
                        if (in_array($newRole, $teamRoles)) {
                            $user->assignRole($teamleaderRole);
                        } else {
                            $user->removeRole($teamleaderRole);
                        }

                        $role = Role::firstOrCreate(["name" => $newRole]);

                        $user->assignRole($role);
                    }
                }
            }

            return redirect()->route('manage-accounts')->with([
                'toast-type' => 'success',
                'toast-message' => __('toast.success-role-update'),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('manage-accounts')->with([
                'toast-type' => 'error',
                'toast-message' => __('toast.error-account-saving'),
            ]);
        }
    }
}
