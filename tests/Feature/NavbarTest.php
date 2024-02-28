<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NavbarTest extends TestCase
{
    public function test_home_link()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(__('navbar.home'));
    }

    public function test_cart_link()
    {
        $response = $this->get(__('navbar.cart'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.cart'));
    }

    public function test_checkout_link()
    {
        $response = $this->get(__('navbar.checkout'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.checkout'));
    }

    public function test_manage_accounts_link()
    {
        $response = $this->get(__('navbar.manage_accounts'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.manage_accounts'));
    }

    public function test_manage_products_link()
    {
        $response = $this->get(__('navbar.manage_products'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.manage_products'));
    }

    public function test_login_link()
    {
        $response = $this->get(__('navbar.login'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.login'));
    }

    public function test_home_link_name()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.home'));
    }

    public function test_cart_link_name()
    {
        $response = $this->get(route('cart'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.cart'));
    }

    public function test_checkout_link_name()
    {
        $response = $this->get(route('checkout'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.checkout'));
    }

    public function test_manage_accounts_link_name()
    {
        $response = $this->get(route('manage-accounts'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.admin'));
    }

    public function test_manage_products_link_name()
    {
        $response = $this->get(route('manage-products'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.admin'));
    }

    public function test_login_link_name()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.login'));
    }
}
