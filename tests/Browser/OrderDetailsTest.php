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
                ->visit(route('orders-user.details-order', ['orderId' => $order->id]))
                ->pressAndWaitFor(__('orders/order_details.cancel_order'), 10)
                ->press(__('orders/order_details.cancel_order_confirm'))
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
