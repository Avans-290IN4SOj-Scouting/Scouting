<?php

namespace App\Http\Controllers;
foreach (glob("Viewmodels/*.php") as $filename)
{
    include $filename;
}

class ProductController extends Controller
{
    public function productOverview()
    {
        $products = Product::all();
        $groups = ProductGroup::all();
        ## $connectGroups = ProductProductGroup::all(); Not implemented
        $sizes = ProductSize::all();
        $connectSizes = ProductProductSize::all();
        $categories = ProductType::all();

        $productsModel = array();
        foreach ($products as $product)
        {
            $productViewmodel = new ProductViewmodel();
            $productViewmodel->name = $product->name;
            $productViewmodel->category = $categories->where('id', $product->product_type_id)->first()->name;
            ## $productViewmodel->picture = $product->picture; Not implemented
            foreach ($sizes as $size)
            {
                $productViewmodel->priceForSize[$size->name] = $connectSizes->where('product_id', $product->id)->where('product_size_id', $size->id)->first()->price;
            }
            ## $productViewmodel->groups = $connectGroups->where('product_id', $product->id)->where('product_group_id')->toArray(); Not implemented
            $productsModel[] = $productViewmodel;
        }


        return view('Products.Overview', ['products' => $productsModel]);
    }

    public function addProduct()
    {
        return view('Products.Add');
    }

    public function createProduct()
    {
        $product = new ProductViewmodel();
        $product->setName(request('name'));
        $product->setCategory(request('category'));
        $product->setPicture(request('picture'));
        $product->setPriceForSize(request('priceForSize'));
        $product->setGroups(request('groups'));


        DB::beginTransaction();
        try {
            Product::create([
                'name' => $product->getName(),
                'discount' => 0,
                'product_type_id' => $this->catagoryToId($product->getCategory()),
                ## 'picture' => $product->getPicture() Not implemented
            ]);

            $sizes = ProductSize::all();
            foreach (array_keys($product->setPriceForSize) as $size) {
                if (!$sizes->where('size', $size)->first()) {
                    ProductSize::create(['size' => $size]);
                }
            }

            $sizes = ProductSize::all();
            foreach (array_keys($product->setPriceForSize) as $size) {
                ProductProductSize::create([
                    'product_id' => Product::where('name', $product->getName())->first()->id,
                    'product_size_id' => $sizes->where('size', $size)->first()->id,
                    'price' => $product->setPriceForSize[$size]
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect('/products');
    }

    public function editProduct($productId)
    {
        ## $product = Product::find($productId);
        return view('Products.Edit', ['product' => $product]);
    }

    public function updateProduct()
    {

    }

    private function catagoryToId($category)
    {
        $categories = ProductType::all();
        return $categories->where('name', $category)->first()->id;
    }
}
