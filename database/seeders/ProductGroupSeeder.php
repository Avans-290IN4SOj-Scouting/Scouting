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
        $test1Product = Product::where('name', 'TestHeren')->first();
        $test2Product = Product::where('name', 'TestDames')->first();
        $test3Product = Product::where('name', 'TestUnisex')->first();

        $kabouterGroup = Group::where('name', 'Kabouters')->first();
        $welpenGroup = Group::where('name', 'Welpen')->first();
        $scoutsGroup = Group::where('name', 'Scouts')->first();

        $kabouterGroup->products()->attach($test3Product);
        $welpenGroup->products()->attach($test1Product);
        $welpenGroup->products()->attach($test2Product);
        $scoutsGroup->products()->attach($test2Product);
        $scoutsGroup->products()->attach($test3Product);

    }
}
