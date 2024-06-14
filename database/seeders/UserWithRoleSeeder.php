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
            'email' => 'admin@scoutingazg.nl',
        ])->first();
        $admin->assignRole('admin');

        $groupLeader = User::factory(1)->create([
            'email' => 'beversgidsen@scoutingazg.nl',
        ])->first();
        $groupLeader->assignRole('teamleader');
        $groupLeader->assignRole('bevers_a');
        $groupLeader->assignRole('gidsen_a');
    }
}
