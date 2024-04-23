<?php

namespace Tests\Feature;

use App\Enum\DeliveryStatus;
use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class ManageOrdersTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_see_new_order(): void
    {
        $admin = User::factory()
            ->create(['email' => 'admin@test.nl'])
            ->assignRole('admin');
        $user = User::factory()
            ->create(['email' => 'user@test.nl'])
            ->assignRole('user');

        $order = Order::create([
            'order_date' => Carbon::now(),
            'lid_name' => 'test',
            'group_id' => 1,
            'user_id' => $user->id,
            'order_status_id' => 1,
        ]);
        OrderLine::create([
            'order_id' => $order->id,
            'product_id' => 1,
            'amount' => 1,
            'product_price' => 12.34,
            'product_size' => 'S',
            'product_image_path' => 'image/products/placeholder.png'
        ]);
        OrderLine::create([
            'order_id' => $order->id,
            'product_id' => 2,
            'amount' => 2,
            'product_price' => 22.33,
            'product_size' => 'S',
            'product_image_path' => 'image/products/placeholder.png'
        ]);

        $response = $this->actingAs($admin)
            ->post(route('manage.orders.cancel-order', ['id' => $order->id]));

        $response->assertStatus(302);

        $this->assertTrue($order->fresh()->orderStatus->status == DeliveryStatus::Cancelled->value);
    }
}
