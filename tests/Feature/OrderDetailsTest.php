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
}
