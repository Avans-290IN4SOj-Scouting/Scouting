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
        //
        OrderStatus::create([
            "status"=> "Cancelled",
        ]);
        OrderStatus::create([
            "status"=> "PayedBack",
        ]);
        OrderStatus::create([
            "status"=> "AwaitingPayment",
        ]);
        OrderStatus::create([
            "status"=> "InProgress",
        ]);
        OrderStatus::create([
            "status"=> "Delivered",
        ]);
        OrderStatus::create([
            "status"=> "Completed",
        ]);
    }
}
