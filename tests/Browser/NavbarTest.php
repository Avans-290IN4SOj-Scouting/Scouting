<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NavbarTest extends DuskTestCase
{
    public function test_home_link()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee(__('navbar.home'));
        });
    }

    public function test_cart_link()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(__('route.shopping-cart'))
                ->assertSee(__('orders.shoppingcart'));
        });
    }

    public function test_checkout_link()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(__('route.checkout'))
                ->assertSee(__('orders.order'));
        });
    }

    public function test_login_link()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(__('navbar.login'))
                ->assertSee(__('navbar.login'));
        });
    }

    public function test_responsiveness_screenshots()
    {
        $this->browse(function (Browser $browser) {
            $browser->responsiveScreenshots('navbar');
        });
    }

    public function test_admin_navlink_visible()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(__('navbar.login'))
                ->type('email', 'admin@admin')
                ->type('password', 'password')
                ->press(__('auth.sign-in'))
                ->assertPathIs('/')
                ->assertSee(__('navbar.admin'));
        });
    }

    public function test_responsiveness_hamburgermenu()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(400, 700)
                ->screenshot('navbar-mobile')
                ->click('.hs-collapse-toggle')
                ->waitForText(__('navbar.account'))
                ->assertSee(__('navbar.home'))
                ->assertSee(__('navbar.cart'))
                ->assertSee(__('navbar.checkout'))
                ->screenshot('navbar-mobile-expanded');
            $browser->maximize();
        });
    }

    public function test_active_link()
    {
        $this->browse(function (Browser $browser) {
            $browser->clickLink(__('navbar.checkout'));
            $browser->assertSeeIn('.active-nav-link', __('navbar.checkout'));
        });
    }
}
