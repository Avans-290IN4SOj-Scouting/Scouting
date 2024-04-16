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
            'status' => 'placed',
        ]);

        OrderStatus::create([
            'status' => 'cancelled',
        ]);

        OrderStatus::create([
            'status' => 'payed',
        ]);
    }
}
