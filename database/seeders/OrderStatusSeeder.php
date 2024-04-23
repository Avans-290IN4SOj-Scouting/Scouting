<?php

namespace Database\Seeders;

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
            'status' => 'cancelled',
        ]);

        OrderStatus::create([
            'status' => 'payment_refunded',
        ]);

        OrderStatus::create([
            'status' => 'awaiting_payment',
        ]);

        OrderStatus::create([
            'status' => 'processing',
        ]);

        OrderStatus::create([
            'status' => 'delivered',
        ]);

        OrderStatus::create([
            'status' => 'finalized',
        ]);
    }
}
