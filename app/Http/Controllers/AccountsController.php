<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Lang;

class AccountsController extends Controller
{
    public function index()
    {
        try {
            $accounts = User::whereNot('email', Auth::user()->email)
                ->with(["roles" => function ($query) {
                    $query->whereNot('name', 'teamleader');
                }])->sortable()->paginate(10);

            $roles = Role::whereNot('name', 'teamleader')->get();

            $allRoles = Role::all()->pluck('name');

            $localisedRoles = $allRoles->reduce(function ($carry, $role) {
                if ($role !== 'teamleader') {
                    $carry[] = __('manage-accounts/roles.' . $role);
                }

                return $carry;
            }, []);

            return view("admin.accounts", ["accounts" => $accounts, "roles" => $roles, "search" => null, "allroles" => $localisedRoles]);
        } catch (\Exception $e) {
            return redirect()->route('home')->with([
                'toast-type' => 'error',
                'toast-message' => __('toast/messages.error-account-loading'),
            ]);
        }
    }

    public function search(Request $request)
    {
        $search = $request->input('q');

        $accounts = User::whereNot('email', Auth::user()->email)
            ->with(["roles" => function ($query) {
                $query->whereNot('name', 'teamleader');
            }])
            ->where('email', 'like', "%$search%")
            ->sortable()
            ->paginate(10);

        $roles = Role::whereNot('name', 'teamleader')->get();

        return view('admin.accounts', ['accounts' => $accounts, 'roles' => $roles, 'search' => $search]);
    }

    public function updateRoles(Request $request)
    {
        try {
            $accounts = json_decode($request->input("userRoles"), true);

            $teamRoles = Role::where("name", "LIKE", "team_%")->pluck("name")->toArray();

            foreach ($accounts as $account) {
                $user = User::where("email", $account["email"])->first();

                if ($user && isset($account["newRoles"])) {
                    $user->roles()->detach();

                    foreach ($account["newRoles"] as $newRole) {
                        if (in_array($newRole, $teamRoles)) {
                            $teamleaderRole = Role::where("name", "teamleader")->first();
                            $user->assignRole($teamleaderRole);
                        }

                        $role = Role::firstOrCreate(["name" => $newRole]);
                        $user->assignRole($role);
                    }
                }
            }

            return redirect()->route('manage.accounts.index')->with([
                'toast-type' => 'success',
                'toast-message' => __('toast/messages.success-role-update'),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('manage.accounts.index')->with([
                'toast-type' => 'error',
                'toast-message' => __('toast/messages.error-account-saving'),
            ]);
        }
    }
}
