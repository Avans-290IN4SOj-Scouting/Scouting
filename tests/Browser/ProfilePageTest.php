<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfilePageTest extends DuskTestCase
{
    /**
     * Responsive screenshot test.
     *
     * @group profile
     */
    public function test_responsiveness()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit(route('profile.index'))
                ->responsiveScreenshots('/profile/profile');
        });
    }

    /**
     * Test the profile page.
     *
     * @group profile
     */
    public function test_profile_page()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit(route('profile.index'))
                ->type('old-password', 'password')
                ->type('new-password', 'new-password')
                ->type('repeat-password', 'new-password')
                ->press(__('auth/profile.edit_password'))
                ->assertSee(__('auth/profile.password_updated'))
                ->assertRouteIs('login');

            $browser->type('email', $user->email)
                ->type('password', 'new-password')
                ->press(__('auth/auth.sign-in'))
                ->assertRouteIs('profile.index');
        });
    }
}
