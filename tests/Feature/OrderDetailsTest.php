<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\GmailService;


class OrderDetailsTest extends TestCase
{
    public function test_cancel_order_successful(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $order = Order::factory()->create(['status' => 'awaiting_payment']);

        $response = $this->post(route('orders-user.cancel-order', ['orderId' => $order->id]));

        $response->assertRedirect();
        $response->assertSessionHas('toast-type', 'success');
        $response->assertSessionHas('toast-message', __('toast/messages.success-order-cancelled'));

        $this->assertEquals('cancelled', $order->fresh()->status);
    }

    public function test_cancel_order_unsuccessful(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $order = Order::factory()->create(['status' => 'finalized']);

        $response = $this->post(route('orders-user.cancel-order', ['orderId' => $order->id]));

        $response->assertRedirect();
        $response->assertSessionHas('toast-type', 'error');
        $response->assertSessionHas('toast-message', __('toast/messages.error-order-not-cancelled'));

        $this->assertEquals('finalized', $order->fresh()->status);
    }

    public function test_order_not_found(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('orders-user.cancel-order', ['orderId' => 999]));

        $response->assertRedirect();
        $response->assertSessionHas('toast-type', 'error');
        $response->assertSessionHas('toast-message', __('toast/messages.error-order-not-found'));
    }
}
