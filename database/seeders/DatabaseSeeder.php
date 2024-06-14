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
        $this->call([
            ProductTypeSeeder::class,
            ProductSizeSeeder::class,
            ProductVarietySeeder::class,
            ProductSeeder::class,
            GroupSeeder::class,
            ProductGroupSeeder::class,
            RoleSeeder::class,
            UserWithRoleSeeder::class,
//            OrderSeeder::class,
        ]);
    }
}
