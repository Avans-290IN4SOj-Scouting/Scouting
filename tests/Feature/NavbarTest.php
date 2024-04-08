<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class NavbarTest extends TestCase
{
    // TODO
    public function test_home_link()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(__('navbar.home'));
    }

    // TODO
    public function test_cart_link()
    {
        $response = $this->get(route('orders.shoppingcart.index'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.cart'));
    }

    // TODO
    public function test_checkout_link()
    {
        $response = $this->get(route('orders.checkout.order'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.checkout'));
    }

    // TODO
    public function test_login_link()
    {
        $response = $this->get(route('login'));

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
        $response = $this->get(route('orders.shoppingcart.index'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.cart'));
    }

    public function test_checkout_link_name()
    {
        $response = $this->get(route('orders.checkout.order'));

        $response->assertStatus(200);
        $response->assertSee(__('navbar.checkout'));
    }

    public function test_manage_accounts_link_name()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)
            ->get(route('manage.accounts.index'));

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
