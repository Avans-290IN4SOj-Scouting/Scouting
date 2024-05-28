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
use LengthException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('productTypes', 'groups')->get();
        $productsModel = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'category' => $product->productTypes->pluck('type')->toArray(),
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

        return view('admin.products', [
            'products' => $productsModel
        ]);
    }

    // GET
    public function add()
    {
        $categories = ProductType::all();
        $groups = Group::all();
        $productSizes = ProductSize::whereNot('size', 'Default')->get();

        return view('admin.add-product', [
            'baseCategories' => $categories,
            'baseGroups' => $groups,
            'baseProductSizes' => $productSizes,
            'price_sizeErrorTypes' => PriceSizeErrorEnum::toArray(),
            'sizes' => ProductSize::all(),
        ]);
    }

    // GET
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
        return view('admin.edit-product', [
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

            'sizes' => ProductSize::all(),
        ]);
    }

    // POST
    public function store(ProductCreationRequest $request)
    {
        $product = Product::create([
            'name' => $request->input('name'),
            'image_path' => '/images/products/placeholder.png'
        ]);
        $product->image_path = $this->savePicture($request->file('af-submit-app-upload-images'), $product->id);

        DB::beginTransaction();
        try
        {
            // Set custom sizes and prices
            $sizes = $request->input('size_input', []);
            $prices = $request->input('price_input', []);

            for ($i = 0; $i < count($sizes); $i++)
            {
                $size = $sizes[$i];
                $price = $prices[$i];
                $product->productSizes()->attach($product->id, ['product_size_id' => $size, 'price' => $price]);
            }

            // Groups
            $groups = $request->input('products-group-multiselect');
            foreach ($groups as $inputGroup)
            {
                $group = Group::where('name', '=', $inputGroup)->first();
                $product->groups()->attach($group);
            }

            // Categories / Colors
            $categories = $request->input('products-category-multiselect');
            foreach ($categories as $inputCategory)
            {
                $category = ProductType::where('type', '=', $inputCategory)->first();
                $product->productTypes()->attach($category);
            }

            DB::commit();
            $product->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();

            return redirect()->route('manage.products.index')->with([
                'toast-type' => 'error',
                'toast-message' => __('toast/messages.error-product-add')
            ]);
        }

        return redirect()->route('manage.products.index')->with([
            'toast-type' => 'success',
            'toast-message' => __('toast/messages.success-product-add')
        ]);
    }

    // POST
    public function update(ProductEditRequest $request, $productId)
    {
        $product = Product::find($productId);
        if ($product === null)
        {
            return redirect()->back()->with('error', __('manage-products/products.product_not_found'));
        }

        // Name
        if ($product->name !== $request->input('name'))
        {
            $product->name = $request->input('name');
        }

        // Image
        if($request->file('af-submit-app-upload-images'))
        {
            $product->image_path = $this->savePicture($request->file('af-submit-app-upload-images'), $product->id);
        }

        // Active/Inactive
        $product->inactive = $request->has('inactive-checkbox') ? 1 : 0;

        DB::beginTransaction();
        try
        {
            // Set custom sizes and prices
            $productSizePrices = $product->productSizes;

            $inputSizes = $request->input('size_input', []);
            $inputPrices = $request->input('price_input', []);

            foreach ($productSizePrices as $productSizePrice)
            {
                $key = array_search($productSizePrice->pivot->product_size_id, $inputSizes);
                if ($key === false) {
                    $product->productSizes()->detach($productSizePrice);
                } else {
                    unset($inputSizes[$key]);
                    unset($inputPrices[$key]);
                }
            }
            // Add remaining
            // dd($detached, $inputSizes, $inputPrices);
            foreach ($inputSizes as $inputSize)
            {
                $index = array_search($inputSize, $inputSizes);
                $size = $inputSizes[$index];
                $price = $inputPrices[$index];
                $product->productSizes()->attach($product->id, ['product_size_id' => $size, 'price' => $price]);
            }

            // Groups
            $productGroups = $product->groups;
            $inputGroups = $request->input('products-group-multiselect');
            foreach ($productGroups as $group)
            {
                $key = array_search($group->name, $inputGroups);
                if ($key === false) {
                    $product->groups()->detach($group);
                } else {
                    unset($inputGroups[$key]);
                }
            }
            // Add remaining
            foreach ($inputGroups as $inputGroup)
            {
                $group = Group::where('name', '=', $inputGroup)->first();
                $product->groups()->attach($group);
            }

            // Categories / Colors
            $productCategories = $product->productTypes;
            $inputCategories = $request->input('products-category-multiselect');
            foreach ($productCategories as $category)
            {
                $key = array_search($category->type, $inputCategories);
                if ($key === false) {
                    $product->productTypes()->detach($category);
                } else {
                    unset($inputCategories[$key]);
                }
            }
            // Add remaining
            foreach ($inputCategories as $inputCategory)
            {
                $category = ProductType::where('type', '=', $inputCategory)->first();
                $product->productTypes()->attach($category);
            }

            DB::commit();
            $product->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            dd($e);
            return redirect()->route('manage.products.index')->with([
                'toast-type' => 'error',
                'toast-message' => __('toast/messages.error-product-add')
            ]);
        }

        return redirect()->route('manage.products.index')->with([
            'toast-type' => 'success',
            'toast-message' => __('toast/messages.success-product-add')
        ]);

        // $validatedData = $request->validated();
        // $product = Product::find($productId);

        // if (!$product) {
        //     return redirect()->back()->with('error', __('manage-products/products.not_found'));
        // }

        // if ($product->name !== $validatedData['name']) {
        //     $product->name = $validatedData['name'];
        // }

        // if($request->file('af-submit-app-upload-images')) {
        //     $product->image_path = $this->savePicture($request->file('af-submit-app-upload-images'), $product->id);
        // }

        // ProductProductSize::where('product_id', $product->id)->delete();
        // if ($request->has('priceForSize')) {
        //     foreach ($validatedData['priceForSize'] as $size => $price) {
        //         if ($price !== null) {
        //             $productSize = ProductSize::firstOrCreate(['size' => $size]);
        //             $product->productSizes()->syncWithoutDetaching([$productSize->id => ['price' => $price]]);
        //         } else {
        //             $existingProductSize = ProductSize::where('size', $size)->first();
        //             if ($existingProductSize) {
        //                 $product->productSizes()->detach($existingProductSize->id);
        //             }
        //         }
        //     }
        // }
        // if (!empty($validatedData['custom_prices']) && !empty($validatedData['custom_sizes'])) {
        //     foreach ($validatedData['custom_prices'] as $index => $customPrice) {
        //         $customSize = $validatedData['custom_sizes'][$index];
        //         if ($customPrice !== null && trim($customPrice) !== '') {
        //             $productSize = ProductSize::firstOrCreate(['size' => $customSize]);
        //             $product->productSizes()->syncWithoutDetaching([$productSize->id => ['price' => $customPrice]]);
        //         } else {
        //             $productSize = ProductSize::where('size', $customSize)->first();
        //             if ($productSize) {
        //                 $product->productSizes()->detach($productSize->id);
        //             }
        //         }
        //     }
        // }
        // $product->productTypes()->detach();
        // foreach ($validatedData['products-category-multiselect'] as $categoryName) {
        //     $category = ProductType::firstOrCreate(['type' => $categoryName]);
        //     $product->productTypes()->attach($category);
        // }

        // $product->groups()->detach();
        // foreach ($validatedData['products-group-multiselect'] as $groupName) {
        //     $group = Group::firstOrCreate(['name' => $groupName]);
        //     $product->groups()->attach($group);
        // }

        // $isInactive = $request->has('inactive-checkbox') ? 1 : 0;
        // $product->inactive = $isInactive;

        // $product->save();
        // return redirect()->route('manage.products.index')->with([
        //     'toast-type' => 'success',
        //     'toast-message' => __('toast/messages.success-product-update')
        // ]);
    }

    private function savePicture($picture, $id)
    {
        if (!$picture) {
            return "/images/products/placeholder.png";
        }
        try {
            Storage::disk('public')->put('/images/products/product-' . $id . '.png', $picture->get());
            return '/images/products/product-' . $id . '.png';
        }
        catch (\Exception $e){
            return "/images/products/placeholder.png";
        }
    }
}
