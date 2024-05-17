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

        $groupLeader = User::factory(1)->create([
            'email' => 'groepsleider@azge.nl',
        ])->first();
        $groupLeader->assignRole('teamleader');
        $groupLeader->assignRole('bevers_a');
        $groupLeader->assignRole('gidsen_a');

        $user = User::factory(1)->create()->first();
        $user->assignRole('teamleader');
        $user->assignRole('bevers_a');
        $user->assignRole('gidsen_a');
    }
}
