<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // This is actually stock per product per size, rip
        // Stock::create([
        //     'product_id' => 1,
        //     'amount' => 11
        // ]);

        // Stock::create([
        //     'product_id' => 2,
        //     'amount' => 12
        // ]);

        // Stock::create([
        //     'product_id' => 3,
        //     'amount' => 13
        // ]);
    }
}
