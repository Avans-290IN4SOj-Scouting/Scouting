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
            $this->populateProductViewModel($product, $productViewmodel);
            $productsModel[] = $productViewmodel;
        }

        return view('admin.products', ['products' => $productsModel, 'categories' => $categories]);
    }

    public function editProduct($productId)
    {
        $product = Product::with(['productType', 'groups', 'productSizes'])->find($productId);

        if (!$product) {
            return redirect('/products');
        }

        $productViewModel = new ProductViewmodel();
        $this->populateProductViewModel($product, $productViewModel);

        return view('admin.EditProduct', [
            'product' => $product,
            'productViewModel' => $productViewModel,

        ]);
    }

    private function populateProductViewModel($product, $productViewmodel)
    {
        $productViewmodel->name = $product->name;
        $productViewmodel->category = $product->productType->type;
        $productViewmodel->groups = $product->groups()->pluck('name')->toArray();

        $sizesWithPrices = ProductProductSize::where('product_id', $product->id)->get();
        $sizes = [];
        foreach ($sizesWithPrices as $sizeWithPrice) {
            $size = ProductSize::find($sizeWithPrice->product_size_id);
            if ($size) {
                $sizeData = [
                    'size' => $size->size,
                    'price' => $sizeWithPrice->price,
                ];
                $sizes[] = $sizeData;
            }
        }
        $productViewmodel->sizesWithPrices = $sizes;

        $productViewmodel->id = $product->id;

        return $productViewmodel;
    }

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
        return view('admin.addProduct');
    }

    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha_num:ascii',
            // 'category' => 'required|string|in:heren,dames,unisex',
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

        dd($product);

        $product->setPriceForSize(array_filter($product->priceForSize, function ($price) {
            return $price != null;
        }));
        $product->setGroups(array_filter($product->groups, function ($group) {
            return $group != null;
        }));

        $product->setCategory('heren');
        // $product->setPicture('uploads/placeholder.jpg');

        if ($validator->fails()) {
            return view('admin.addProduct')->with('error', $validator);
        }
        if (empty($product->priceForSize) || empty($product->groups)) {
            return view('admin.addProduct')->with('error', 'Vul alle velden in');
        }

        // Fetch all categories
        $categories = ProductType::all();

        DB::beginTransaction();
        try {
            $category = $this->catagoryToId($product->getCategory());

            // Create the product with all attributes including image_path
            Product::create([
                'name' => $product->getName(),
                'discount' => 0,
                'product_type_id' => $category,
                'image_path' => $product->getPicture(), // Assign the image path here
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
        return view('admin.addProduct', ['categories' => $categories]); // Pass categories to the view
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
