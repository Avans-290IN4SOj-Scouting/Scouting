<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
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

    /*
     * Is used to send data to JS files without exposing the return data
     */
    public function getData(Request $request)
    {
        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            $allAccounts = $this->getAllUsers()->get();
            $roles = $this->getRoles();
            $langNoOptions = __('toast/messages.warning-accounts-no-options');
            $langNoRoles = __('manage-accounts/accounts.no_roles');
            $langUnknownRole = __('manage-accounts/accounts.unknown_role');
            $langNoChanges = __('toast/messages.warning-accounts');

            return response()->json(
                [
                    'allAccounts' => $allAccounts,
                    'roles' => $roles,
                    'langNoOptions' => $langNoOptions,
                    'langNoRoles' => $langNoRoles,
                    'langUnknownRole' => $langUnknownRole,
                    'langNoChanges' => $langNoChanges,
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
                $normalizedFilter = Str::snake(Str::lower($filter));

                $roleId = Role::where('name', $normalizedFilter)->value('id');

                if ($roleId) {
                    $accounts = $accounts->whereHas('roles', function ($query) use ($normalizedFilter) {
                        return $query->where('name', $normalizedFilter);
                    });
                }
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
                $formattedRole = Str::title(str_replace('_', ' ', $role));
                $carry[] = $formattedRole;
            }

            return $carry;
        }, []);
    }

    public function updateRoles(Request $request)
    {
        $accounts = json_decode($request->input("userRoles"), true);

        foreach ($accounts as $account) {
            $user = User::where("email", $account["email"])->first();

            if ($user && isset($account["newRoles"])) {
                $user->roles()->detach();

                $hasLeaderRole = false;

                foreach ($account["newRoles"] as $newRole) {
                    $role = Role::where('id', $newRole)->first();

                    if ($role && $role->group_id) {
                        $hasLeaderRole = true;
                    }

                    $user->assignRole($role);
                }

                if ($hasLeaderRole) {
                    $teamleaderRole = Role::where('name', self::TEAM_LEADER)->first();

                    if ($teamleaderRole) {
                        $user->assignRole($teamleaderRole);
                    }
                }
            }
        }

        return redirect()->route('manage.accounts.index')->with([
            'toast-type' => 'success',
            'toast-message' => __('toast/messages.success-role-update'),
        ]);
    }
}
