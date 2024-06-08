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

        $this->call([
            ProductTypeSeeder::class,
            ProductSizeSeeder::class,
            ProductVarietySeeder::class,
            ProductSeeder::class,
            GroupSeeder::class,
            ProductGroupSeeder::class,
        ]);


        $this->call([
            RoleSeeder::class,
            UserWithRoleSeeder::class,
            OrderSeeder::class,
        ]);

        foreach ($users as $user) {
            $user->assignRole('user');
        }
    }
}
