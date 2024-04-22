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
        // hardcoded status, remove when enum is added
        OrderStatus::create([
            'id' => 1,
            'status' => 'not-cancelled',
        ]);
    }
}
