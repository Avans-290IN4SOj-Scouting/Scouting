<?php

namespace Tests\Browser;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;
use App\Models\User;

class ManageAccountsTest extends DuskTestCase
{
    public function testView()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('manage.accounts.index'))
                ->assertRouteIs('manage.accounts.index');
        });
    }

    public function test_responsiveness_screenshots()
    {
        $admin = User::factory()->create(['email' => 'res@ponsive'])->assignRole('admin');
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('manage.accounts.index'))
                ->responsiveScreenshots('manage-accounts/manage-accounts');
        });
    }

    public function testExistingRoleAddsRoleSelect() {
        $admin = User::factory()->create(['email' => 'role.existing.select']);
        $admin->assignRole('admin');

        $user = User::find(1);
        $role = Role::find(4); // bevers_a
        $group = Group::find($role->group_id);
        $user->assignRole($role);

        $this->browse(function (Browser $browser) use ($admin, $user, $group) {
            $browser->loginAs($admin)
                ->visitRoute('manage.accounts.index')
                ->pause(5000)
                ->within('#roleContainer' . $user->id, function ($container) use ($group) {
                    $container->waitFor('#subroleSelect' . $group->name . '1')
                        ->assertVisible('#subroleSelect' . $group->name . '1');
                });
        });
    }
    
    public function testAddRoleAndShowModal()
    {
        $admin = User::factory()->create(['email' => 'modal.displayed']);
        $admin->assignRole('admin');

        $userToEdit = User::find(1);
        $groupToSelect = Group::find(1);

        $this->browse(function (Browser $browser) use ($admin, $userToEdit, $groupToSelect) {
            $browser->loginAs($admin)
                ->visitRoute('manage.accounts.index')
                ->pause(5000)
                ->whenAvailable('#roleContainer' . $userToEdit->id, function ($container) {
                    $container->click('#addRoleButton');
                })
                ->waitFor('#selectRole' . $userToEdit->id)
                ->assertVisible('#selectRole' . $userToEdit->id)
                ->select('#selectRole' . $userToEdit->id, $groupToSelect->name)
                ->pause(5000)
                ->within('#roleContainer' . $userToEdit->id, function ($container) use ($groupToSelect) {
                    $container->waitFor('#subroleSelect' . $groupToSelect->name . '1')
                        ->assertVisible('#subroleSelect' . $groupToSelect->name . '1');
                })
                ->waitFor('#saveBtn')
                ->click('#saveBtn')
                ->assertVisible('#confirmModal');
        });
    }

    public function testNoModalDisplayedWithNoChanges()
    {
        $admin = User::factory()->create(['email' => 'no.modal.displayed']);
        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('manage.accounts.index'))
                ->pause(5000)
                ->waitFor('#saveBtn')
                ->assertVisible('#saveBtn')
                ->press('#saveBtn')
                ->waitFor('#dismiss-toast')
                ->assertVisible('#dismiss-toast');
        });
    }
}

