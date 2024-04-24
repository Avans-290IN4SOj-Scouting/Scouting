<?php

namespace Database\Seeders;

use App\Enum\DeliveryStatus;
use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::create([
            'status' => DeliveryStatus::Cancelled->value,
        ]);

        OrderStatus::create([
            'status' => DeliveryStatus::PaymentRefunded->value,
        ]);

        OrderStatus::create([
            'status' => DeliveryStatus::AwaitingPayment->value,
        ]);

        OrderStatus::create([
            'status' => DeliveryStatus::Processing->value,
        ]);

        OrderStatus::create([
            'status' => DeliveryStatus::Delivered->value,
        ]);

        OrderStatus::create([
            'status' => DeliveryStatus::Finalized->value,
        ]);
    }
}
