<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Groups
        $kabouters = Group::where('name', 'Kabouters')->first();
        $welpen = Group::where('name', 'Welpen')->first();
        $scouts = Group::where('name', 'Scouts')->first();
        $gidsen = Group::where('name', 'Gidsen')->first();
        $bevers = Group::where('name', 'Bevers')->first();
        $zeeverkenners = Group::where('name', 'Zeeverkenners')->first();

        // Das
        $das = Product::where('name', 'Das')->first();

        $kabouters->products()->attach($das);
        $welpen->products()->attach($das);
        $scouts->products()->attach($das);
        $gidsen->products()->attach($das);
        $bevers->products()->attach($das);
        $zeeverkenners->products()->attach($das);

        // Dasring
        $dasring = Product::where('name', 'Dasring')->first();

        $kabouters->products()->attach($dasring);
        $welpen->products()->attach($dasring);
        $scouts->products()->attach($dasring);
        $gidsen->products()->attach($dasring);
        $bevers->products()->attach($dasring);
        $zeeverkenners->products()->attach($dasring);

        // Bevers
        $poloBevers = Product::where('name', 'Polo - Bevers')->first();
        $truiBevers = Product::where('name', 'Trui - Bevers')->first();

        $bevers->products()->attach($poloBevers);
        $bevers->products()->attach($truiBevers);

        // Gidsen
        $poloGidsen = Product::where('name', 'Polo - Gidsen')->first();
        $truiGidsen = Product::where('name', 'Trui - Gidsen')->first();

        $gidsen->products()->attach($poloGidsen);
        $gidsen->products()->attach($truiGidsen);
    }
}
