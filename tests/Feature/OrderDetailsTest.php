<?php

namespace Tests\Feature;

use App\Enum\DeliveryStatus;
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

        $order = Order::factory()->create(['status' => DeliveryStatus::AwaitingPayment, 'user_id' => $user->id]);

        $response = $this->post(route('orders.cancel', ['id' => $order->id]));

        $response->assertRedirect();
        $response->assertSessionHas('toast-type', 'success');
        $response->assertSessionHas('toast-message', __('toast/messages.success-order-cancelled'));

        $this->assertEquals('cancelled', $order->fresh()->status);
    }

    public function test_cancel_order_not_authorized(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userToTest = User::factory()->create();
        $order = Order::factory()->create(['status' => DeliveryStatus::Finalized, 'user_id' => $userToTest->id]);

        $response = $this->post(route('orders.cancel', ['id' => $order->id]));

        $response->assertRedirect();
        $response->assertSessionHas('toast-type', 'error');
        $response->assertSessionHas('toast-message', __('toast/messages.error-nonauthorized-order'));

        $this->assertEquals('finalized', $order->fresh()->status);
    }

    public function test_order_not_found(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('orders.cancel', ['id' => 999]));

        $response->assertRedirect();
        $response->assertSessionHas('toast-type', 'error');
        $response->assertSessionHas('toast-message', __('toast/messages.error-order-not-found'));
    }
}
