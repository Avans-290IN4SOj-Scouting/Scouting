<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            DeliveryStateSeeder::class,
            DeliveryStatusSeeder::class,
            FeedbackFormSeeder::class,
            FeedbackTypeSeeder::class,
            GroupSeeder::class,
            OrderLineSeeder::class,
            OrderSeeder::class,
            OrderStatusSeeder::class,
            ProductSeeder::class,
            ProductSizeSeeder::class,
            ProductTypeSeeder::class,
            StockSeeder::class
        ]);
    }
}
