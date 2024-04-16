<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'order_date' => '2024-02-25',
            'lid_name' => 'jantje',
            'group_id' => 1,
            'user_id' => 1,
            'order_status_id' => 1,
        ]);

        Order::create([
            'order_date' => '2024-02-25',
            'lid_name' => 'pietje',
            'group_id' => 1,
            'user_id' => 2,
            'order_status_id' => 2,
        ]);

        Order::create([
            'order_date' => '2024-02-25',
            'lid_name' => 'broodje',
            'group_id' => 1,
            'user_id' => 3,
            'order_status_id' => 3,
        ]);
    }
}
