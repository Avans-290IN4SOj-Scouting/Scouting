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
            $browser->visit(__('navbar.cart'))
                ->assertSee(__('navbar.cart'));
        });
    }

    public function test_checkout_link()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(__('navbar.checkout'))
                ->assertSee(__('navbar.checkout'));
        });
    }

    //TODO: Add checks if user has right role
    public function test_manage_accounts_link()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(__('navbar.manage_accounts'))
                ->assertSee(__('navbar.admin'));
        });
    }

    //TODO: Add checks if user has right role
    public function test_manage_products_link()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(__('navbar.manage_products'))
                ->assertSee(__('navbar.admin'));
        });
    }

    //TODO: Add checks if user has right role
    public function test_admin_dropdown()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(__('navbar.manage_products'))
                ->mouseover('.hs-dropdown')
                ->assertSee(__('navbar.manage_products'));
        });
        $this->browse(function (Browser $browser) {
            $browser->visit(__('navbar.manage_accounts'))
                ->mouseover('.hs-dropdown')
                ->assertSee(__('navbar.manage_accounts'));
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

    public function test_responsiveness_hamburgermenu()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(400, 700)
                ->screenshot('navbar-mobile')
                ->click('.hs-collapse-toggle')
                // TODO: if user is logged in wait for other text
                ->waitForText(__('navbar.login'))
                ->assertSee(__('navbar.home'))
                ->assertSee(__('navbar.cart'))
                ->assertSee(__('navbar.checkout'))
                ->assertSee(__('navbar.admin'))
                ->screenshot('navbar-mobile-expanded');
            $browser->maximize();
        });
    }

    // TODO uncomment
    // public function test_active_link()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->clickLink(__('navbar.checkout'));

    //         $browser->assertSeeIn('.active-nav-link', __('navbar.checkout'));
    //     });
    // }
}
