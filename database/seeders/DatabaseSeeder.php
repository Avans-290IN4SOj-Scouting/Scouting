<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            // ORDER OF SEEDING IS VERY IMPORTANT!!!
            // Also, php artisan migrate:fresh --seed  |  https://laravel.com/docs/10.x/seeding#running-seeders
            ProductTypeSeeder::class,
            ProductSizeSeeder::class,
            ProductSeeder::class,
            GroupSeeder::class,
            ProductGroupSeeder::class,
            StockSeeder::class,
            OrderSeeder::class,
            OrderLineSeeder::class,

            // Below are unordered
            DeliveryStateSeeder::class,
            DeliveryStatusSeeder::class,
            FeedbackFormSeeder::class,
            FeedbackTypeSeeder::class,
            OrderStatusSeeder::class,
        ]);

        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserWithRoleSeeder::class);
    }
}
