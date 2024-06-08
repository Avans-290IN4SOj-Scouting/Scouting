<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardName = 'web';

        $roles = ['admin', 'teamleader', 'user'];

        foreach ($roles as $role) {
            if (!Role::where('name', $role)->exists()) {
                Role::create([
                    'name' => $role,
                    'guard_name' => $guardName,
                ]);
            }
        }

        $teamleaderRoles = [
            ['team_bevers', '1'],
            ['team_gidsen', '2'],
            ['team_kabouters', '3'],
            ['team_scouts', '4'],
            ['team_waterwerk', '5'],
            ['team_welpen', '6']
        ];

        foreach ($teamleaderRoles as $subRole) {
            if (!Role::where('name', $subRole[0])->exists()) {
                Role::create([
                    'name' => $subRole[0],
                    'group_id' => $subRole[1],
                    'guard_name'=> $guardName,
                ]);
            }
        }
    }
}
