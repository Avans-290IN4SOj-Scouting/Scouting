<?php

namespace Tests\Browser;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
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

    public function testAddRoleSelect()
    {
        $admin = User::factory()->create(['email' => 'role.dropdown.test']);
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
                });
        });
    }

    /**
     * @group manage
     * @return void
     */
    public function testModalAppearsAfterRoleChange()
    {
        $admin = User::factory()->create(['email' => 'admin@test.com'])->assignRole('admin');

        $testUser = User::factory()->create(['email' => 'aaa@a.a'])->assignRole('user');

        $this->browse(function (Browser $browser) use ($admin, $testUser) {
            $browser->loginAs($admin)
                ->visit(route('manage.accounts.index'))
                ->clickLink(__('manage-accounts/accounts.email'))
                ->click('[data-account-email="' . $testUser->email . '"]')
                ->waitFor('#selectRole-div')
                ->click(__('[data-value="admin"]'))
                ->click('[data-account-email="' . $testUser->email . '"]')
                ->click('#saveBtn')
                ->waitFor('.confirmModal', 10)
                ->assertVisible('.confirmModal')
                ->assertSee(__('manage-accounts/accounts.modal_warning_title'))
                ->assertSee(__('manage-accounts/accounts.confirm_button'))
                ->screenshot('manage-accounts/modal');
        });
    }

    public function testNoModalDisplayedWithNoChanges()
    {
        $admin = User::factory()->create(['email' => 'no.model.displayed']);
        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('manage.accounts.index'))
                ->click('.saveBtn')
                ->waitFor('.toast-warning', 10)
                ->assertVisible('.toast-warning')
                ->screenshot('manage-accounts/warning-toast');
        });
    }
}

