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
            $accounts = User::sortable()->with(["roles" => function ($query) {
                $query->where('name', '!=', 'teamleader');
            }])->paginate(6);

            return view("admin.accounts", ["accounts" => $accounts]);
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

                if ($user && isset($account["newRole"])) {

                    if ($user->hasRole($account["oldRole"])) {
                        $user->roles()->detach();
                    }

                    $teamleaderRole = Role::where("name", "teamleader")->first();
                    if (in_array($account["newRole"], $teamRoles)) {
                        $user->assignRole($teamleaderRole);
                    } else {
                        $user->removeRole($teamleaderRole);
                    }

                    $translatedRole = Lang::has("accounts." . $account["newRole"])
                        ? Lang::get("accounts." . $account["newRole"])
                        : $account["newRole"];

                    $role = Role::firstOrCreate(["name" => $translatedRole]);

                    $user->assignRole($role);
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
