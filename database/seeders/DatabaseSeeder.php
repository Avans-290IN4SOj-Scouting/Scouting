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
        $users = User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            // ORDER OF SEEDING IS VERY IMPORTANT!!!
            // Also, php artisan migrate:fresh --seed  |  https://laravel.com/docs/10.x/seeding#running-seeders
            ProductTypeSeeder::class,
            ProductSizeSeeder::class,
            ProductVarietySeeder::class,
            ProductSeeder::class,
            GroupSeeder::class,
            ProductGroupSeeder::class,
            StockSeeder::class,

            // Below are unordered
            FeedbackFormSeeder::class,
            FeedbackTypeSeeder::class,
            // GroupSeeder::class,
        ]);


        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class, UserWithRoleSeeder::class,
            OrderSeeder::class,
            OrderLineSeeder::class
        ]);

        foreach ($users as $user) {
            $user->assignRole('user');
        }
    }
}
