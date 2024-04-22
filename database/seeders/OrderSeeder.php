<?php

namespace Database\Seeders;

use App\Models\DeliveryState;
use App\Models\DeliveryStatus;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order = Order::create([
            'order_date' => '2024-02-25',
            'email'=> 'admin@mail.com',
            'lid_name' => 'jantje',
            'order_status_id' => 1,
            'user_id' => 13,
            'group_id' => 1
        ]);

        $order->orderStatus = OrderStatus::first();

        $orders[] = Order::factory()
            ->has(OrderLine::factory())
            ->has(DeliveryState::factory())
            ->count(30)->create();

        foreach($orders as $order) {
            $order->status = OrderStatus::inRandomOrder()->first();
        }
    }
}
