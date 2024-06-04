<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AccountsController extends Controller
{
    private const TEAM_LEADER = 'teamleader';

    public function index()
    {
        $allAccounts = $this->getAllUsers()->get();

        $accounts = $this->getAllUsers()->sortable()->paginate(10);

        return view("admin.accounts",
            [
                "accounts" => $accounts,
                "allAccounts" => $allAccounts,
                "roles" => $this->getRoleSelection(),
                "rolesJson" => $this->getRoles()->toJson(),
                "search" => null,
                "allroles" => $this->getAllRoles(),
                "selected" => null
            ]);
    }

    public function getData(Request $request)
    {
        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            $allAccounts = $this->getAllUsers()->get();
            $roles = $this->getRoles();
            $langNoOptions = __('toast/messages.warning-accounts-no-options');
            $langNoRoles = __('manage-accounts/accounts.no_roles');
            $langUnknownRole = __('manage-accounts/accounts.unknown_role');

            return response()->json(
                [
                    'allAccounts' => $allAccounts,
                    'roles' => $roles,
                    'langNoOptions' => $langNoOptions,
                    'langNoRoles' => $langNoRoles,
                    'langUnknownRole' => $langUnknownRole,
                ]);
        }

        return redirect()->back()->with([
            'toast-type' => 'error',
            'toast-message' => __('toast/messages.error-no_access_to_url'),
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

    private function getRoleSelection()
    {
        $groupSelection = Group::pluck('name', 'id');

        $adminRole = Role::where('name', 'admin')->first();

        return $groupSelection->add($adminRole->display_name);
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
