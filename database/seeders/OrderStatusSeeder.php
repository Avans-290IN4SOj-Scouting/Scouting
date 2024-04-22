<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // hardcoded status, remove when enum is added
       
        \App\Models\OrderStatus::create([
            "status" => \App\Enum\OrderStatus::AwaitingPayment
        ]);
        \App\Models\OrderStatus::create([
            "status" => \App\Enum\OrderStatus::Cancelled
        ]);
        \App\Models\OrderStatus::create([
            "status" => \App\Enum\OrderStatus::Delivered
        ]);
        \App\Models\OrderStatus::create([
            "status" => \App\Enum\OrderStatus::Finalized
        ]);
        \App\Models\OrderStatus::create([
            "status" => \App\Enum\OrderStatus::PaymentRefunded
        ]);
        \App\Models\OrderStatus::create([
            "status" => \App\Enum\OrderStatus::Processing
        ]);
    }
}
