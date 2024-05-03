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

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = ProductType::all();
        $productsModel = [];

        foreach ($products as $product) {
            $productDetails = [
                'name' => $product->name,
                'category' => $product->productType->type,
                'groups' => $product->groups()->pluck('name')->toArray(),
                'sizesWithPrices' => $this->getSizesWithPrices($product),
                'id' => $product->id,
            ];
            $productsModel[] = $productDetails;
        }

        return view('admin.products', ['products' => $productsModel, 'categories' => $categories]);
    }

    private function getSizesWithPrices($product)
    {
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
        return $sizes;
    }

    public function update(ProductEditRequest $request, $productId)
    {
        $validatedData = $request->validated();

        $product = Product::find($productId);


        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $categoryId = $this->categoryToId($validatedData['category']);
        $product->product_type_id = $categoryId;



        $validPictureAdded = ($request->hasFile('af-submit-app-upload-images') && $request->file('af-submit-app-upload-images')->isValid());
        if ($validPictureAdded) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
        }
        if ($product->name !== $validatedData['name']) {
            $product->name = $validatedData['name'];
        }
        if ($validPictureAdded) {
            $product->image_path = $this->savePicture($request->file('af-submit-app-upload-images'), $product->getName());
        }

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
        $product->groups()->detach();
        foreach ($validatedData['products-group-multiselect'] as $groupName) {
            $group = Group::firstOrCreate(['name' => $groupName]);
            $product->groups()->attach($group);
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->image_path = $imagePath;
        }
        $product->save();
        return redirect()->route('manage.products.index', ['id' => $product->id])->with('success', 'Product updated successfully.');
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
        ]);
    }

    public function edit($productId)
    {

        $categories = ProductType::all();
        $groups = Group::all();
        $productSizes = ProductSize::whereNot('size', 'Default')->get();
        $product = Product::with(['productType', 'groups', 'productSizes'])->find($productId);
        $chosenCategorie = $product->productType;
        $chosenGroups = $product->groups;
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
            'baseCategories' => $categories,
            'baseGroups' => $groups,
            'baseProductSizes' => $productSizes,
            'baseChosenCategorie' => $chosenCategorie,
            'chosenGroups' => $chosenGroups,
            'sizesWithPrices' => $sizes,
            'defaultSizeWithPrice' => $defaultSize,
            'nameDisabled' => $nameDisabled,
        ]);
    }

    public function store(ProductCreationRequest $request)
    {
        $product = new Product();
        $product->setName($request->input('name'));
        $product->setCategory($request->input('category'));
        $product->image_path = $this->savePicture($request->file('af-submit-app-upload-images'), $product->getName());
        $product->setPriceForSize($request->input('priceForSize'));
        $product->setGroups($request->input('products-group-multiselect'));
        $product->setPriceForSize(array_filter($product->priceForSize, function ($price) {
            return $price != null;
        }));
        $product->setGroups(array_filter($product->groups, function ($group) {
            return $group != null;
        }));

        DB::beginTransaction();
        try {
            $category = $this->categoryToId($product->getCategory());
            $newProduct = Product::create([
                'name' => $product->getName(),
                'discount' => 0,
                'product_type_id' => $category,
                'image_path' => $product->image_path,
            ]);

            $sizes = ProductSize::all();
            foreach ($product->priceForSize as $size => $price) {
                if (!$sizes->where('size', $size)->first()) {
                    ProductSize::create(['size' => $size]);
                }
            }

            foreach ($product->priceForSize as $size => $price) {
                $databaseProduct = Product::where('name', $product->getName())->first();
                $productSizeId = ProductSize::where('size', $size)->first()->id;
                if (!$databaseProduct->productSizes()->where('product_size_id', $productSizeId)->exists()) {
                    $databaseProduct->productSizes()->attach(
                        $databaseProduct->id,
                        ['product_size_id' => $productSizeId, 'price' => $price]
                    );
                }
            }

            $groups = Group::all();
            foreach ($product->groups as $group) {
                if (!$groups->where('name', $group)->first()) {
                    throw (new \Exception('Group not found'));
                }
            }

            foreach ($product->groups as $group) {
                $newProduct->groups()->attach(Group::where('name', $group)->first());
            }

            DB::commit();

            $request->session()->flash('toast-type', 'success');
            $request->session()->flash('toast-message', __('toast/messages.success-product-add'));
            return redirect()->route('manage.products.index');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function savePicture($picture, $name)
    {
        if (Storage::disk('public')->put('/images/products/' . $name . '.png', $picture->get())) {
            return '/images/products/' . $name . '.png';
        }
        return "/images/products/placeholder.png";
    }

    private function categoryToId($category)
    {
        $category = strtolower($category);
        $productType = ProductType::firstOrCreate(['type' => $category]);
        return $productType->id;
    }
}
