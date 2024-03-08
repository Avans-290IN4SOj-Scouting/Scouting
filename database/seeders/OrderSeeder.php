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
            'email' => 'scouting@scouting.nl',
            'lid_name' => 'jantje',
            'postal_code' => '1234AB',
            'house_number' => '1',
            'streetname' => 'Straat',
            'cityname' => 'Stad'
        ]);
    }
}
