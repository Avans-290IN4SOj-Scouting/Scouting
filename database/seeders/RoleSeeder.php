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

        $teamleaderRoles = ['team_bevers', 'team_gidsen', 'team_kabouters', 'team_scouts', 'team_zeeverkenners', 'team_welpen'];

        foreach ($teamleaderRoles as $subRole) {
            if (!Role::where('name', $subRole)->exists()) {
                Role::create([
                    'name' => $subRole,
                    'guard_name'=> $guardName,
                ]);
            }
        }
    }
}
