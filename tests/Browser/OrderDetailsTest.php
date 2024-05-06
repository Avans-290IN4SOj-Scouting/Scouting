<?php

namespace Tests\Browser;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class OrderDetailsTest extends DuskTestCase
{
    use RefreshDatabase;

    public function test_responsiveness_screenshots(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['status' => 'processing', 'user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $order) {
            $browser->loginAs($user)
                ->visit("/orderDetails/{$order->id}")
                ->responsiveScreenshots('orderDetails/orderDetails');
        });
    }

    public function test_cancel_order_successful(): void
    {
        $user = User::factory()->create(['email' => 'test@mail.com']);

        $order = Order::factory()->create(['status' => 'processing', 'user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $order) {
            $browser->loginAs($user)
                ->visit("/orderDetails/{$order->id}")
                ->click('#cancel-button')
                ->waitFor('.toast-success', 10)
                ->assertVisible('.toast-success')
                ->assertSee(__('delivery_status.cancelled'));
        });
    }

    public function test_cancel_order_unsuccessful(): void
    {
        $user = User::factory()->create(['email' => 'test@mail.com']);

        $order = Order::factory()->create(['status' => 'finalized', 'user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $order) {
            $browser->loginAs($user)
                ->visit("/orderDetails/{$order->id}")
                ->assertDontSee(__('orders/orders.cancel-order'));
        });
    }
}
