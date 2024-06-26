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
        $waterwerk = Group::where('name', 'Waterwerk')->first();
        $leiders = Group::where('name', 'Leiders')->first();

        // Das
        $das = Product::where('name', 'Das')->first();

        $kabouters->products()->attach($das);
        $welpen->products()->attach($das);
        $scouts->products()->attach($das);
        $gidsen->products()->attach($das);
        $bevers->products()->attach($das);
        $waterwerk->products()->attach($das);
        $leiders->products()->attach($das);

        // Dasring
        $dasring = Product::where('name', 'Dasring')->first();

        $kabouters->products()->attach($dasring);
        $welpen->products()->attach($dasring);
        $scouts->products()->attach($dasring);
        $gidsen->products()->attach($dasring);
        $bevers->products()->attach($dasring);
        $waterwerk->products()->attach($dasring);
        $leiders->products()->attach($dasring);

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

        // Kabouters
        $poloKabouters = Product::where('name', 'Polo - Kabouters')->first();
        $truiKabouters = Product::where('name', 'Trui - Kabouters')->first();

        $kabouters->products()->attach($poloKabouters);
        $kabouters->products()->attach($truiKabouters);

        // Scouts/Verkenners
        $poloScouts = Product::where('name', 'Polo - Scouts')->first();
        $truiScouts = Product::where('name', 'Trui - Scouts')->first();

        $scouts->products()->attach($poloScouts);
        $scouts->products()->attach($truiScouts);

        // Waterwerk
        $poloWaterwerkV = Product::where('name', 'Polo - Waterwerk dames')->first();
        $poloWaterwerkM = Product::where('name', 'Polo - Waterwerk heren')->first();
        $truiWaterwerk = Product::where('name', 'Trui - Waterwerk')->first();

        $waterwerk->products()->attach($poloWaterwerkV);
        $waterwerk->products()->attach($poloWaterwerkM);
        $waterwerk->products()->attach($truiWaterwerk);

        // Welpen
        $poloWelpen = Product::where('name', 'Polo - Welpen')->first();
        $truiWelpen = Product::where('name', 'Trui - Welpen')->first();

        $welpen->products()->attach($poloWelpen);
        $welpen->products()->attach($truiWelpen);

        // Leiders
        $poloLeidsters = Product::where('name', 'Polo - Leidsters')->first();
        $poloLeiders = Product::where('name', 'Polo - Leiders')->first();
        $truiLeiding = Product::where('name', 'Trui - Leiding')->first();

        $leiders->products()->attach($poloLeidsters);
        $leiders->products()->attach($poloLeiders);
        $leiders->products()->attach($truiLeiding);
    }
}
