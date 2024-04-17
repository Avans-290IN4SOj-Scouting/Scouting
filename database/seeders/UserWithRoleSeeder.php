<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserWithRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory(1)->create([
            'email' => 'admin@admin.nl',
        ])->first();
        $admin->assignRole('admin');

        $user = User::factory(1)->create()->first();
        $user->assignRole('team_bevers');
        $user->assignRole('team_gidsen');
    }
}
