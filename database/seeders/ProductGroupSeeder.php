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
        // Products
        $das = Product::where('name', 'Das')->first();

        // Groups
        $kabouters = Group::where('name', 'Kabouters')->first();
        $welpen = Group::where('name', 'Welpen')->first();
        $scouts = Group::where('name', 'Scouts')->first();
        $gidsen = Group::where('name', 'Gidsen')->first();
        $bevers = Group::where('name', 'Bevers')->first();
        $zeeverkenners = Group::where('name', 'Zeeverkenners')->first();

        // Attach products to groups
        $kabouters->products()->attach($das);
        $welpen->products()->attach($das);
        $scouts->products()->attach($das);
        $gidsen->products()->attach($das);
        $bevers->products()->attach($das);
        $zeeverkenners->products()->attach($das);
    }
}
