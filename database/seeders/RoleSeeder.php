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
        $roles = ['admin', 'teamleader', 'user'];

        foreach ($roles as $role) {
            if (!Role::where('name', $role)->exists()) {
                Role::create(['name' => $role]);
            }
        }

        $teamleaderRoles = ['bevers', 'gidsen', 'kabouters', 'scouts', 'zeeverkenners', 'welpen'];

        $teamleaderRole = Role::where('name', 'teamleader')->first();

        foreach ($teamleaderRoles as $subRole) {
            if (!Role::where('name', $subRole)->exists()) {
                Role::create([
                    'name' => $subRole,
                ]);
            }
        }
    }
}
