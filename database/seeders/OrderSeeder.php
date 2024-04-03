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
            'email' => 'scouting@scouting.nl',
            'lid_name' => 'jantje',
            'postal_code' => '1234AB',
            'house_number' => '1',
            'streetname' => 'Straat',
            'cityname' => 'Stad',
            'group_id' => 1
        ]);

        $order->orderStatus = OrderStatus::first();

        $orders = Order::factory()
            // ->has(OrderStatus::inRandomOrder()->first())
            ->has(OrderLine::factory())
            ->has(DeliveryState::factory()
            // ->has(DeliveryStatus::inRandomOrder()->first())
            )
            ->count(3)->create();

        foreach($orders as $order) {
            $order->status = OrderStatus::inRandomOrder()->first();
        }
    }
}
