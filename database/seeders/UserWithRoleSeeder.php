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
        {
            $admin = User::factory(1)->create([
                'email' => 'admin@admin.nl',
            ])->first();
            $admin->assignRole('admin');
        }

        {
            $admin = User::factory(1)->create([
                'email' => 'jeroen-admin@admin.nl',
            ])->first();
            $admin->assignRole('admin');
        }

        {
            $admin = User::factory(1)->create([
                'email' => 'linde-admin@admin.nl',
            ])->first();
            $admin->assignRole('admin');
        }

        {
            $admin = User::factory(1)->create([
                'email' => 'delite-admin@admin.nl',
            ])->first();
            $admin->assignRole('admin');
        }

        {
            $admin = User::factory(1)->create([
                'email' => 'vincent-admin@admin.nl',
            ])->first();
            $admin->assignRole('admin');
        }

        $groupLeader = User::factory(1)->create([
            'email' => 'groepsleider@azge.nl',
        ])->first();
        $groupLeader->assignRole('teamleader');
        $groupLeader->assignRole('team_bevers');
        $groupLeader->assignRole('team_gidsen');

        $user = User::factory(1)->create()->first();
        $user->assignRole('team_bevers');
        $user->assignRole('team_gidsen');
    }
}
