<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use App\Models\ProductProductSize;
use App\Models\ProductSize;
use App\Models\ProductType;
use App\Models\OrderLine;
use Illuminate\Http\Request;
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
        $validatedData = $request->validated();#

        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Update category if changed
        $categoryId = $this->categoryToId($validatedData['category']);
        $product->product_type_id = $categoryId;

        // Update product price for sizes
        foreach ($validatedData['priceForSize'] as $size => $price) {
            if ($price !== null) {
                // Find or create the corresponding ProductSize
                $productSize = ProductSize::firstOrCreate(['size' => $size]);

                // Update the product price for the size
                $product->productSizes()->syncWithoutDetaching([$productSize->id => ['price' => $price]]);
            }
        }

        // Handle custom prices and sizes
        if (!empty($validatedData['custom_prices']) && !empty($validatedData['custom_sizes'])) {
            foreach ($validatedData['custom_prices'] as $index => $customPrice) {
                $customSize = $validatedData['custom_sizes'][$index];
                if ($customPrice !== null && $customSize !== null) {
                    $productSize = ProductSize::firstOrCreate(['size' => $customSize]);
                    $product->productSizes()->syncWithoutDetaching([$productSize->id => ['price' => $customPrice]]);
                }
            }
        }

        // Update groups
        $product->groups()->detach(); // Remove existing groups
        foreach ($validatedData['products-group-multiselect'] as $groupName) {
            $group = Group::firstOrCreate(['name' => $groupName]);
            $product->groups()->attach($group);
        }

        // Handle image upload if provided
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
        $productSizes = ProductSize::where('size', '!=', 'Default')->get();
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
        $productSizes = ProductSize::where('size', '!=', 'Default')->get();
        $product = Product::with(['productType', 'groups', 'productSizes'])->find($productId);
        $chosenCategorie = $product->productType;
        $chosenGroups = $product->groups;

        $sizesWithPrices = ProductProductSize::where('product_id', $product->id)->get();
        $sizes = [];
        foreach ($sizesWithPrices as $sizeWithPrice) {
            $size = ProductSize::where('size', '!=', 'Default')->find($sizeWithPrice->product_size_id);
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
        if (ProductSize::where('size', 'Default')->first() != null) {
            $defaultSize = [
                'size' => 'Default',
                'price' => ProductProductSize::where('product_id', $product->id)->first()
                    ->where('product_size_id', ProductSize::where('size', 'Default')->first()->id)
                    ->first()->price,
            ];
        }

        // Check if the product has any associated order lines
        $hasOrderLine = OrderLine::where('product_id', $productId)->exists();

        // Determine if name editing should be disabled based on the presence of order lines
        $nameDisabled = $hasOrderLine ? true : false;

        // Return the view with the appropriate data
        return view('admin.editProduct', [
            'product' => $product,
            'baseCategories' => $categories,
            'baseGroups' => $groups,
            'baseProductSizes' => $productSizes,
            'baseChosenCategorie' => $chosenCategorie,
            'chosenGroups' => $chosenGroups,
            'sizesWithPrices' => $sizes,
            'defaultSizeWithPrice' => $defaultSize,
            'nameDisabled' => $nameDisabled, // Pass the name disabled flag to the view
        ]);
    }
    public function store(ProductCreationRequest $request)
    {
        $validData = $request->validated();
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

            // Create the product with all attributes including image_path
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
                // Check if the combination of product_id and product_size_id already exists
                if (!$databaseProduct->productSizes()->where('product_size_id', $productSizeId)->exists()) {
                    // If it doesn't exist, insert the new entry
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

            // Add a success toast message only if new entries were added
            return redirect()->route('manage.products.index');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function savePicture($picture, $name)
    {
        if (!Storage::disk('public')->put('/images/products/' . $name . '.png', $picture->get())) {
            return "/images/products/placeholder.png";
        }
        return '/images/products/' . $name . '.png';
    }

    private function categoryToId($category)
    {
        $category = strtolower($category);
        $categories = ProductType::all()->select('id', 'type');
        if ($categories->where('type', $category)->first() == null) {
            ProductType::create(['type' => $category]);
            $categories = ProductType::all()->select('id', 'type');
        }
        return $categories->where('type', $category)->first()['id'];
    }
}
