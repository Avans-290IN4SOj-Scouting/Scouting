<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class ManageAccountsTest extends DuskTestCase
{
    public function testView()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('manage-accounts'))
                ->screenshot('manage-accounts')
                ->assertUrlIs(env('APP_URL') . __('route.manage_accounts'));
        });
    }

    public function test_responsiveness_screenshots()
    {
        $this->browse(function (Browser $browser) {
            $browser->responsiveScreenshots('manage-accounts');
        });
    }

    public function testRoleDropdown()
    {
        $admin = User::factory()->create(['name' => 'admin']);
        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit(route('manage-accounts'))
                ->select('[data-account-email="' . $admin->email . '"]', __('roles.admin'))
                ->assertSee(__('roles.admin'));
        });
    }

    public function testModalAppearsAfterRoleChange()
    {
        $admin = User::factory()->create(['name' => 'admin']);
        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit(route('manage-accounts'))
                ->select('[data-account-email="' . $admin->email . '"]', __('roles.admin'))
                ->click('#saveBtn')
                ->waitFor('#confirmModal')
                ->assertVisible('#confirmModal')
                ->screenshot('manage-accounts-modal');
        });
    }

    public function testNoModalDisplayedWithNoChanges()
    {
        $admin = User::factory()->create(['name' => 'admin']);
        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit(route('manage-accounts'))
                ->click('#saveBtn')
                ->waitFor('#toast', 10)
                ->assertVisible('#toast')
                ->assertSee(__('toast.warning-accounts'))
                ->screenshot('manage-accounts-warning-toast');
        });
    }
}

