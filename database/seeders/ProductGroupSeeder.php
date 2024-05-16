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
        $test1Product = Product::where('name', 'Wandelschoenen')->first();
        $test2Product = Product::where('name', 'Vest')->first();
        $test3Product = Product::where('name', 'Shirt')->first();
        $test4Product = Product::where('name', 'Broek')->first();
        $test5Product = Product::where('name', 'Hoed')->first();
        $test6Product = Product::where('name', 'Sjaal')->first();
        $test7Product = Product::where('name', 'Riem')->first();

        $beversGroup = Group::where('name', 'Bevers')->first();
        $kaboutersGroup = Group::where('name', 'Kabouters')->first();
        $welpenGroup = Group::where('name', 'Welpen')->first();
        $scoutsGroup = Group::where('name', 'Scouts')->first();

        // Attach 3 products to each group
        $beversGroup->products()->attach($test2Product);
        $beversGroup->products()->attach($test3Product);
        $beversGroup->products()->attach($test4Product);

        $kaboutersGroup->products()->attach($test3Product);
        $kaboutersGroup->products()->attach($test5Product);
        $kaboutersGroup->products()->attach($test7Product);

        $welpenGroup->products()->attach($test2Product);
        $welpenGroup->products()->attach($test4Product);
        $welpenGroup->products()->attach($test6Product);

        $scoutsGroup->products()->attach($test5Product);
        $scoutsGroup->products()->attach($test6Product);
        $scoutsGroup->products()->attach($test7Product);

        // First product gets added to all groups
        {
            $group = Group::where('id', 1)->first();
            $group->products()->attach($test1Product);
        }
        {
            $group = Group::where('id', 2)->first();
            $group->products()->attach($test1Product);
        }
        {
            $group = Group::where('id', 3)->first();
            $group->products()->attach($test1Product);
        }
        {
            $group = Group::where('id', 4)->first();
            $group->products()->attach($test1Product);
        }
    }
}
