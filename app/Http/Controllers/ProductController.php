<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use App\Models\ProductProductSize;
use App\Models\ProductSize;
use App\Models\ProductType;
use App\Models\OrderLine;
use App\Http\Requests\ProductCreationRequest;
use App\Http\Requests\ProductEditRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Enum\PriceSizeErrorEnum;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('productTypes', 'groups')->get();
        $categories = ProductType::all();
        $productsModel = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'category' => implode(', ', $product->productTypes->pluck('type')->toArray()),
                'groups' => $product->groups->pluck('name')->toArray(),
                'sizesWithPrices' => $product->productSizes->map(function ($size) {
                    return [
                        'size' => $size->size,
                        'price' => $size->pivot->price,
                    ];
                }),
                'id' => $product->id,
            ];
        });

        return view('admin.products', ['products' => $productsModel, 'categories' => $categories]);
    }

    public function update(ProductEditRequest $request, $productId)
    {
        $validatedData = $request->validated();
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->back()->with('error', __('manage-products/products.not_found'));
        }

        if ($product->image_path && $product->image_path !== '/images/products/placeholder.png') {
                Storage::disk('public')->delete($product->image_path);
            }
        if ($product->name !== $validatedData['name']) {
            $product->name = $validatedData['name'];
        }
            $product->image_path = $this->savePicture($request->file('af-submit-app-upload-images') ?? '' , $product->name, $product->id);

        ProductProductSize::where('product_id', $product->id)->delete();
        if ($request->has('priceForSize')) {
            foreach ($validatedData['priceForSize'] as $size => $price) {
                if ($price !== null) {
                    $productSize = ProductSize::firstOrCreate(['size' => $size]);
                    $product->productSizes()->syncWithoutDetaching([$productSize->id => ['price' => $price]]);
                } else {
                    $existingProductSize = ProductSize::where('size', $size)->first();
                    if ($existingProductSize) {
                        $product->productSizes()->detach($existingProductSize->id);
                    }
                }
            }
        }
        if (!empty($validatedData['custom_prices']) && !empty($validatedData['custom_sizes'])) {
            foreach ($validatedData['custom_prices'] as $index => $customPrice) {
                $customSize = $validatedData['custom_sizes'][$index];
                if ($customPrice !== null && trim($customPrice) !== '') {
                    $productSize = ProductSize::firstOrCreate(['size' => $customSize]);
                    $product->productSizes()->syncWithoutDetaching([$productSize->id => ['price' => $customPrice]]);
                } else {
                    $productSize = ProductSize::where('size', $customSize)->first();
                    if ($productSize) {
                        $product->productSizes()->detach($productSize->id);
                    }
                }
            }
        }
        $product->productTypes()->detach();
        foreach ($validatedData['products-category-multiselect'] as $categoryName) {
            $category = ProductType::firstOrCreate(['type' => $categoryName]);
            $product->productTypes()->attach($category);
        }

        $product->groups()->detach();
        foreach ($validatedData['products-group-multiselect'] as $groupName) {
            $group = Group::firstOrCreate(['name' => $groupName]);
            $product->groups()->attach($group);
        }

        $isInactive = $request->has('inactive-checkbox') ? 1 : 0;
        $product->inactive = $isInactive;

        $product->save();
        return redirect()->route('manage.products.index')->with('success', __('manage-products/products.update_success'));
    }

    public function add()
    {
        $categories = ProductType::all();
        $groups = Group::all();
        $productSizes = ProductSize::whereNot('size', 'Default')->get();
        return view('admin.addProduct', [
            'baseCategories' => $categories,
            'baseGroups' => $groups,
            'baseProductSizes' => $productSizes,
            'price_sizeErrorTypes' => PriceSizeErrorEnum::toArray(),
        ]);
    }

    public function edit($productId)
    {

        $product = Product::with(['productTypes', 'groups', 'productSizes'])->find($productId);
        if (!$product) {
            // Product not found, redirect back with an error message
            return redirect()->back()->with('error', __('manage-products/products.not_found'));
        }

        $sizesWithPrices = ProductProductSize::where('product_id', $product->id)->get();
        $sizes = [];
        foreach ($sizesWithPrices as $sizeWithPrice) {
            $size = ProductSize::whereNot('size', 'Default')->find($sizeWithPrice->product_size_id);
            if ($size) {
                $sizeData = [
                    'size' => $size->size,
                    'price' => $sizeWithPrice->price,
                ];
                $sizes[] = $sizeData;
            }
        }

        $defaultSize = [
            'size' => 'Default',
            'price' => null,
        ];

        $defaultProductSize = ProductSize::where('size', 'Default')->first();

        if ($defaultProductSize) {
            $defaultProductSizePrice = ProductProductSize::where('product_id', $product->id)
                ->where('product_size_id', $defaultProductSize->id)
                ->first();

            if ($defaultProductSizePrice) {
                $defaultSize['price'] = $defaultProductSizePrice->price;
            }
        }

        $nameDisabled = OrderLine::where('product_id', $productId)->exists();
        return view('admin.editProduct', [
            'product' => $product,
            'baseCategories' => ProductType::all(),
            'baseGroups' => Group::all(),
            'baseProductSizes' => ProductSize::whereNot('size', 'Default')->get(),
            'chosenCategories' => $product->productTypes,
            'chosenGroups' => $product->groups,
            'sizesWithPrices' => $sizes,
            'defaultSizeWithPrice' => $defaultSize,
            'nameDisabled' => $nameDisabled,
            'price_sizeErrorTypes' => PriceSizeErrorEnum::toArray(),
        ]);
    }

    public function store(ProductCreationRequest $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->image_path = $this->savePicture($request->file('af-submit-app-upload-images'), $product->name,$product->id);

        // Set default price if priceForSize is not provided in the request
        $defaultPriceForSize = ['Default' => null];
        $priceForSize = $request->input('priceForSize', $defaultPriceForSize);
        $product->setPriceForSize($priceForSize);

        // Set custom sizes and prices
        $customSizes = $request->input('custom_sizes', []);
        $customPrices = $request->input('custom_prices', []);

        // Merge default and custom sizes and prices
        $sizesAndPrices = array_merge($product->priceForSize, array_combine($customSizes, $customPrices));

        // Set sizes and prices on the product
        $product->setPriceForSize($sizesAndPrices);

        // Set groups & categories
        $product->setGroups($request->input('products-group-multiselect'));
        $product->setTypes($request->input('products-category-multiselect'));

        DB::beginTransaction();
        try {
            $newProduct = Product::create([
                'name' => $product->name,
                'discount' => 0,
                'image_path' => $product->image_path,
            ]);

            // Handle sizes and prices
            foreach ($product->priceForSize as $size => $price) {
                if ($price !== null) {
                    $productSize = ProductSize::firstOrCreate(['size' => $size]);
                    $newProduct->productSizes()->syncWithoutDetaching([$productSize->id => ['price' => $price]]);
                }
            }

            // Handle groups
            foreach ($product->groups as $group) {
                $newProduct->groups()->attach(Group::firstOrCreate(['name' => $group]));
            }
            // Handle categories
            foreach ($product->types as $category) {
                $newProduct->ProductTypes()->attach(ProductType::firstOrCreate(['type' => $category]));
            }

            DB::commit();

            return redirect()->route('manage.products.index')->with([
                'toast-type' => 'success',
                'toast-message' => __('toast/messages.success-product-add')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('manage.products.index')->with([
                'toast-type' => 'error',
                'toast-message' => __('toast/messages.error-product-add')
            ]);
        }
    }
    private function savePicture($picture, $name, $id)
    {
        if (!$picture) {
            return "/images/products/placeholder.png";
        }
        try {
            Storage::disk('public')->put('/images/products/' . $name . $id . '.png', $picture->get());
            return '/images/products/' . $name . $id . '.png';
        }
        catch (\Exception $e){
            return "/images/products/placeholder.png";
        }
    }
}
