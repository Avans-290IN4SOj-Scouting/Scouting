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
        $this->browse(function (Browser $browser) {
            $browser->visit('/orderDetails')
                ->responsiveScreenshots('orderDetails/orderDetails');
        });
    }

    public function test_cancel_order_successful(): void
    {
        $user = User::factory()->create(['email' => 'test@mail.com']);

        $order = Order::factory()->create(['status' => 'processing']);

        $this->browse(function (Browser $browser) use ($user, $order) {
            $browser->loginAs($user)
                ->visit("/orderDetails/{$order->id}")
                ->click('#cancel-button')
                ->waitFor('.toast-success', 10)
                ->assertVisible('.toast-success')
                ->assertSee(__('delivery_status.cancelled'));
        });
    }

    public function test_cancel_order_unsuccessful(): void {
        $user = User::factory()->create(['email' => 'test@mail.com']);

        $order = Order::factory()->create(['status' => 'finalized']);

        $this->browse(function (Browser $browser) use ($user, $order) {
            $browser->loginAs($user)
                ->visit("/orderDetails/{$order->id}")
                ->click('#cancel-button')
                ->waitFor('.toast-error', 10)
                ->assertVisible('.toast-error')
                ->assertSee(__('delivery_status.finalized'));
        });
    }
}
