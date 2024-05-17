<?php

namespace Database\Seeders;

use App\Models\Group;
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
                    'display_name' => $role,
                ]);
            }
        }

        $teamleaderRoles = [
            ['A', '1'],
            ['B', '1'],
            ['C', '1'],
            ['A', '2'],
            ['B', '2'],
            ['A', '3'],
            ['B', '3'],
            ['A', '4'],
            ['A', '5'],
            ['B', '5'],
            ['C', '5'],
            ['D', '5'],
            ['A', '6'],
            ['B', '6'],
        ];

        foreach ($teamleaderRoles as $subRole) {
            if (!Role::where('name', $subRole[0])->exists()) {
                Role::create([
                    'name' => strtolower(Group::where('id', '=', $subRole[1])->first()->name . '_' . $subRole[0]),
                    'display_name' => $subRole[0],
                    'group_id' => $subRole[1],
                    'guard_name'=> $guardName,
                ]);
            }
        }
    }
}
