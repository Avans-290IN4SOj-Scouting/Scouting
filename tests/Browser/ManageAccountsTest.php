<?php

namespace Tests\Browser;

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

    public function testRoleDropdown()
    {
        $admin = User::factory()->create(['email' => 'role.dropdown.test']);
        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('manage.accounts.index'))
                ->click('#selectRole-div')
                ->assertSee(__('manage-accounts/roles.admin'));
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

