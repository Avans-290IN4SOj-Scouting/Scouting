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
        $test1Product = Product::where('name', 'TestHeren1')->first();
        $test2Product = Product::where('name', 'TestDames1')->first();
        $test3Product = Product::where('name', 'TestUnisex1')->first();
        $test4Product = Product::where('name', 'TestSingleSize1')->first();
        $test5Product = Product::where('name', 'TestSingleSize2')->first();

        $kabouterGroup = Group::where('name', 'Kabouters')->first();
        $welpenGroup = Group::where('name', 'Welpen')->first();
        $scoutsGroup = Group::where('name', 'Scouts')->first();

        $kabouterGroup->products()->attach($test3Product);
        $kabouterGroup->products()->attach($test4Product);
        $kabouterGroup->products()->attach($test5Product);
        $welpenGroup->products()->attach($test1Product);
        $welpenGroup->products()->attach($test2Product);
        $scoutsGroup->products()->attach($test2Product);
        $scoutsGroup->products()->attach($test3Product);

        {
            $product = Product::where('id', 1)->first();
            $group = Group::where('id', 1)->first();
            $group->products()->attach($product);
        }
        {
            $product = Product::where('id', 1)->first();
            $group = Group::where('id', 2)->first();
            $group->products()->attach($product);
        }
        {
            $product = Product::where('id', 1)->first();
            $group = Group::where('id', 3)->first();
            $group->products()->attach($product);
        }
        {
            $product = Product::where('id', 1)->first();
            $group = Group::where('id', 4)->first();
            $group->products()->attach($product);
        }
    }
}
