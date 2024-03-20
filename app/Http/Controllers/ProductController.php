<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ProductProductSize;
use App\Models\ProductSize;
use App\Models\ProductType;
use App\Viewmodels\ProductViewmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function productOverview()
    {
        $products = Product::all();
        $categories = ProductType::all();

        $productsModel = [];

        foreach ($products as $product) {
            $productViewmodel = new ProductViewmodel();
            $productViewmodel->name = $product->name;
            $productViewmodel->category = ProductType::find($product->product_type_id)->type;

            // Fetch groups associated with the current product
            $groups = $product->groups()->pluck('name')->toArray();
            $productViewmodel->groups = $groups;

            // Fetch sizes and prices for the current product
            $sizesWithPrices = ProductProductSize::where('product_id', $product->id)->get();
            $sizes = [];
            foreach ($sizesWithPrices as $sizeWithPrice) {
                $sizeData = [
                    'size' => ProductSize::find($sizeWithPrice->product_size_id)->size,
                    'price' => $sizeWithPrice->price,
                ];
                $sizes[] = $sizeData;
            }
            $productViewmodel->sizesWithPrices = $sizes;

            // Add the populated product viewmodel to the products model array
            $productsModel[] = $productViewmodel;
        }

        return view('admin.products', ['products' => $productsModel, 'categories' => $categories]);
    }

    // ProductController.php


    public function viewProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $categories = ProductType::all();

        $productViewModel = new ProductViewmodel();
        $productViewModel->name = $product->name;
        $productViewModel->category = $product->type->type; // Assuming you have defined the relationship in your Product model

        // Fetch groups associated with the product
        $groups = $product->groups()->pluck('name')->toArray();
        $productViewModel->groups = $groups;

        // Fetch sizes and prices for the product
        $sizesWithPrices = ProductProductSize::where('product_id', $product->id)->get();
        $sizes = [];
        foreach ($sizesWithPrices as $sizeWithPrice) {
            $sizeData = [
                'size' => ProductSize::find($sizeWithPrice->product_size_id)->size,
                'price' => $sizeWithPrice->price,
            ];
            $sizes[] = $sizeData;
        }
        $productViewModel->sizesWithPrices = $sizes;

        return view('admin.product', ['product' => $productViewModel, 'categories' => $categories]);
    }

    public function goToAddProduct()
    {
        $categories = ProductType::all();
        $groups = Group::all();
        return view('admin.addProduct', ['baseCategories' => $categories, 'baseGroups' => $groups]);
    }

    public function createProduct(Request $request)
    {
        $categories = ProductType::all()->select('id', 'type');
        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha_num:ascii',
            'category' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($categories) {
                    if ($categories->where('type', $value)->first() == null) {
                        $fail("The $attribute must be a valid category.");
                    }
                }
            ],
            'picture' => 'required|file|image',
            'priceForSize' => [
                'bail',
                'array',
                'required',
                function ($attribute, $value, $fail) {
                    foreach ($value as $price) {
                        if (is_numeric($price) || $price == null) {
                            continue;
                        }
                        $fail("The $attribute must contain only numbers.");
                    }
                }
            ],
            'groups' => 'required|array',
            'description' => 'nullable|string',
        ]);

        $product = new ProductViewmodel();
        $product->setName($request->input('name'));
        $product->setCategory($request->input('category'));
        $product->setPicture($request->file('picture'));
        $product->setPriceForSize($request->input('priceForSize'));
        $product->setGroups($request->input('groups'));
        $product->description = $request->input('description');

        // Remove null values from priceForSize and groups
        $product->setPriceForSize(array_filter($product->priceForSize, function ($price) {
            return $price != null;
        }));
        $product->setGroups(array_filter($product->groups, function ($group) {
            return $group != null;
        }));

        if ($validator->fails()) {
            return view('admin.addProduct')->with('error', $validator);
        }
        if (empty ($product->priceForSize) || empty ($product->groups)) {
            return view('admin.addProduct')->with('error', 'Vul alle velden in');
        }

        DB::beginTransaction();
        try {
            $category = $this->catagoryToId($product->getCategory());

            // Create the product with all attributes including image_path
            Product::create([
                'name' => $product->getName(),
                'discount' => 0,
                'product_type_id' => $category,
                'image_path' => $product->getPicture(), // Assign the image path here
                'description' => $product->description,
            ]);

            $sizes = ProductSize::all();
            foreach ($product->priceForSize as $size => $price) {
                if (!$sizes->where('size', $size)->first()) {
                    ProductSize::create(['size' => $size]);
                }
            }

            $sizes = ProductSize::all();
            foreach ($product->priceForSize as $size => $price) {
                ProductProductSize::create([
                    'product_id' => Product::where('name', $product->getName())->first()->id,
                    'product_size_id' => $sizes->where('size', $size)->first()->id,
                    'price' => $price
                ]);
            }

            // TODO: Link to groups
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return redirect('/Beheer%20producten');
    }


    public function editProduct($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return redirect('/products');
        }
        return view('Products.Edit', ['product' => $product]);
    }

    public function updateProduct()
    {

    }

    private function catagoryToId($category)
    {
        $category = strtolower($category);
        $categories = ProductType::all()->select('id', 'type');
        if ($categories->where('type', $category)->first() == null) {
            dd($category);
        }
        return $categories->where('type', $category)->first()['id'];
    }
}
