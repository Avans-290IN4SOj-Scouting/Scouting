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
        $products = Product::with('productType', 'groups')->get();
        $categories = ProductType::all();
        $productsModel = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'category' => $product->productType->type,
                'groups' => $product->groups->pluck('name')->toArray(),
                'sizesWithPrices' => $this->getSizesWithPrices($product),
                'id' => $product->id,
            ];
        });

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
        $product = Product::findOrFail($productId);

        if ($request->hasFile('af-submit-app-upload-images')) {
            $image = $request->file('af-submit-app-upload-images');
            $imageName = $product->getName() . '_' . time() . '.' . $image->getClientOriginalExtension();
            $product->image_path = $this->savePicture($image, $imageName, $product->id);
        }

        // Update other product attributes
        $product->name = $validatedData['name'];
        $product->product_type_id = $this->categoryToId($validatedData['category']);
        $product->inactive = $request->has('inactive-checkbox') ? 1 : 0;
        $product->save();
        $categoryId = $this->categoryToId($validatedData['category']);
        $product->product_type_id = $categoryId;
        if ($product->image_path && $product->image_path !== '/images/products/placeholder.png') {
            Storage::disk('public')->delete($product->image_path);
        }
        if ($product->name !== $validatedData['name']) {
            $product->name = $validatedData['name'];
        }
        $product->image_path = $this->savePicture($request->file('af-submit-app-upload-images') ?? '', $product->getName(), $product->id);

        // Sync product sizes
        $this->syncProductSizes($product, $validatedData);

        // Sync product groups
        $this->syncProductGroups($product, $validatedData['products-group-multiselect']);

        return redirect()->route('manage.products.index')->with('success', __('manage-products/products.update_success'));
    }

    private function syncProductSizes(Product $product, array $validatedData)
    {
        $product->productSizes()->detach();

        if ($validatedData['priceForSize']) {
            foreach ($validatedData['priceForSize'] as $size => $price) {
                if ($price !== null) {
                    $productSize = ProductSize::firstOrCreate(['size' => $size]);
                    $product->productSizes()->attach($productSize, ['price' => $price]);
                }
            }
        }

        if (!empty($validatedData['custom_prices']) && !empty($validatedData['custom_sizes'])) {
            foreach ($validatedData['custom_prices'] as $index => $customPrice) {
                $customSize = $validatedData['custom_sizes'][$index];
                if ($customPrice !== null && trim($customPrice) !== '') {
                    $productSize = ProductSize::firstOrCreate(['size' => $customSize]);
                    $product->productSizes()->attach($productSize, ['price' => $customPrice]);
                }
            }
        }
    }

    private function syncProductGroups(Product $product, array $groupNames)
    {
        $product->groups()->detach();

        foreach ($groupNames as $groupName) {
            $group = Group::firstOrCreate(['name' => $groupName]);
            $product->groups()->attach($group);
        }
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
        $product = Product::with(['productType', 'groups', 'productSizes'])->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', __('manage-products/products.not_found'));
        }
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
        $requestData = $request->all();
        $image = $request->file('af-submit-app-upload-images');
        $imageName = $request->input('name');
        $uniqueImageName = $imageName . '_' . time() . '.' . $image->getClientOriginalExtension();
        $product = Product::create([
            'name' => $imageName,
            'image_path' => $this->savePicture($image, $uniqueImageName),
            'product_type_id' => $this->categoryToId($requestData['category']),
            'discount' => 0,
        ]);
        $defaultPriceForSize = ['Default' => null];
        $priceForSize = $requestData['priceForSize'] ?? $defaultPriceForSize;
        $customSizes = $requestData['custom_sizes'] ?? [];
        $customPrices = $requestData['custom_prices'] ?? [];
        $sizesAndPrices = array_merge($priceForSize, array_combine($customSizes, $customPrices));
        foreach ($sizesAndPrices as $size => $price) {
            if ($price !== null) {
                $productSize = ProductSize::firstOrCreate(['size' => $size]);
                $product->productSizes()->syncWithoutDetaching([$productSize->id => ['price' => $price]]);
            }
        }
        $groups = $requestData['products-group-multiselect'] ?? [];
        foreach ($groups as $group) {
            $product->groups()->attach(Group::firstOrCreate(['name' => $group]));
        }
        $request->session()->flash('toast-type', 'success');
        $request->session()->flash('toast-message', __('toast/messages.success-product-add'));
        return redirect()->route('manage.products.index');
    }
    private function savePicture($picture, $name)
    {
        if (!$picture) {
            return "/images/products/placeholder.png";
        }
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
