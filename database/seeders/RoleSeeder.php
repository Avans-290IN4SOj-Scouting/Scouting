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
        $chrA = 65;

        foreach ($teamleaderRoles as $subRole) {
            if (!Role::where('name', $subRole)->exists()) {
                $maxAmountSubdivisions = mt_rand(1, 5);
                for ($i = 0; $i < $maxAmountSubdivisions; $i++) {
                    $asciiSymbol = chr($i + $chrA);

                    Role::create([
                        'name' => $subRole  . '_' . $asciiSymbol,
                        'guard_name' => $guardName,
                    ]);
                }
            }
        }
    }
}
