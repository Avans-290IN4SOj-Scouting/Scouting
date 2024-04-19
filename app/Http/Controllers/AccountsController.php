<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AccountsController extends Controller
{
    private const TEAM_LEADER = 'teamleader';

    public function index()
    {
        $accounts = $this->getAllUsers()->sortable()->paginate(10);
        $roles = $this->getRoles();

        return view("admin.accounts",
            [
                "accounts" => $accounts,
                "roles" => $roles,
                "search" => null,
                "allroles" => $this->getAllRoles(),
                "selected" => null
            ]);
    }

    public function filter(Request $request)
    {
        $search = $request->input('q');
        $accounts = $this->getAllUsers()
            ->where('email', 'like', "%$search%");

        $filter = $request->input('filter');
        if ($filter) {
            try {
                $accounts = $accounts->whereHas('roles', function ($query) use ($filter) {
                    $filter = UserRoleEnum::delocalised($filter);
                    return $query->where('name', $filter);
                });
            } catch (\UnhandledMatchError $e) {
                return redirect()->route('manage.accounts.index')->with([
                    'toast-type' => 'error',
                    'toast-message' => __('manage-accounts/accounts.filter_error'),
                ]);
            }
        }

        $accounts = $accounts->sortable()->paginate(10);
        $roles = $this->getRoles();

        return view("admin.accounts",
            [
                "accounts" => $accounts,
                "roles" => $roles,
                "search" => $search,
                "allroles" => $this->getAllRoles(),
                "selected" => $filter
            ]);
    }

    private function getAllUsers()
    {
        return User::whereNot('email', auth()->user()->email)
            ->with(["roles" => function ($query) {
                $query->whereNot('name', self::TEAM_LEADER);
            }]);
    }

    private function getRoles()
    {
        return Role::whereNot('name', self::TEAM_LEADER)->get();
    }

    private function getAllRoles()
    {
        $allRoles = Role::all()->pluck('name');

        return $allRoles->reduce(function ($carry, $role) {
            if ($role !== self::TEAM_LEADER) {
                $carry[] = __('manage-accounts/roles.' . $role);
            }

            return $carry;
        }, []);
    }

    public function updateRoles(Request $request)
    {
        $accounts = json_decode($request->input("userRoles"), true);

        $teamRoles = Role::where("name", "LIKE", "team_%")->pluck("name")->toArray();

        foreach ($accounts as $account) {
            $user = User::where("email", $account["email"])->first();

            if ($user && isset($account["newRoles"])) {
                $user->roles()->detach();

                foreach ($account["newRoles"] as $newRole) {
                    if (in_array($newRole, $teamRoles)) {
                        $teamleaderRole = Role::where("name", self::TEAM_LEADER)->first();
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
    }
}
