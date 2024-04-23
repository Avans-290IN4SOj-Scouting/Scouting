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
}
