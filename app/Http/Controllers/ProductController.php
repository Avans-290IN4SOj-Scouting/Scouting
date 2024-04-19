<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use App\Models\ProductProductSize;
use App\Models\ProductSize;
use App\Models\ProductType;
use App\Viewmodels\ProductViewmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
    public function updateProduct(Request $request, $productId)
    {
        $customMessages = [
            'category.required' => __('validation.category.required'),
            'groups.required' => __('validation.groups.required'),
        ];

        $validatedData = $request->validate([
            'category' => 'required|string',
            'groups' => 'required|array',
            'description' => 'nullable|string',
            'priceForSize' => 'required|array',
            'priceForSize.*' => 'nullable|numeric',
            'custom_prices' => 'nullable|array',
            'custom_prices.*' => 'nullable|numeric',
            'custom_sizes' => 'nullable|array',
            'custom_sizes.*' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $customMessages);

        $product = Product::find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Update product attributes
        $product->description = $validatedData['description']; // Update description if provided

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
        foreach ($validatedData['groups'] as $groupName) {
            $group = Group::firstOrCreate(['name' => $groupName]);
            $product->groups()->attach($group);
        }

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->image_path = $imagePath;
        }

        $product->save();

        return redirect()->route('manage.products.edit.index', ['id' => $product->id])->with('success', 'Product updated successfully.');
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

    //    public function viewProduct($productId)
//    {
//        $product = Product::findOrFail($productId);
//        $categories = ProductType::all();
//
//        $productViewModel = new ProductViewmodel();
//        $productViewModel->name = $product->name;
//        $productViewModel->category = $product->type->type;
//
//        $groups = $product->groups()->pluck('name')->toArray();
//        $productViewModel->groups = $groups;
//
//        $sizesWithPrices = ProductProductSize::where('product_id', $product->id)->get();
//        $sizes = [];
//        foreach ($sizesWithPrices as $sizeWithPrice) {
//            $sizeData = [
//                'size' => ProductSize::find($sizeWithPrice->product_size_id)->size,
//                'price' => $sizeWithPrice->price,
//            ];
//            $sizes[] = $sizeData;
//        }
//        $productViewModel->sizesWithPrices = $sizes;
//
//        return view('admin.product', ['product' => $productViewModel, 'categories' => $categories]);
//    }

    public function goToAddProduct($failure = null)
    {
        $categories = ProductType::all();
        $groups = Group::all();
        $productSizes = ProductSize::where('size', '!=', 'Default')->get();
        if ($failure == null)
            return view('admin.addProduct', [
                'baseCategories' => $categories,
                'baseGroups' => $groups,
                'baseProductSizes' => $productSizes,
            ]);
        if (is_string($failure)) {
            return view('admin.addProduct', [
                'baseCategories' => $categories,
                'baseGroups' => $groups,
                'baseProductSizes' => $productSizes,
                'errors' => [$failure],
            ]);
        }
        // validator
        return view('admin.addProduct', [
            'baseCategories' => $categories,
            'baseGroups' => $groups,
            'baseProductSizes' => $productSizes,
            'errors' => $failure->errors(),
        ]);
    }

    public function goToEditProduct($productId, $failure = null)
    {
        // TODO:: OrderLine toevoegen
        $categories = ProductType::all();
        $groups = Group::all();
        $productSizes = ProductSize::where('size', '!=', 'Default')->get();
        $product = Product::with(['productType', 'groups', 'productSizes'])->find($productId);
        $chosenCategorie = $product->productType;
        $chosenGroups = $product->groups;
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
        if ($failure == null)
            return view('admin.editProduct', [
                'product' => $product,
                'baseCategories' => $categories,
                'baseGroups' => $groups,
                'baseProductSizes' => $productSizes,
                'baseChosenCategorie' => $chosenCategorie,
                'chosenGroups' => $chosenGroups,
                'sizesWithPrices' => $sizes,
            ]);
        if (is_string($failure)) {
            return view('admin.editProduct', [
                'product' => $product,
                'baseCategories' => $categories,
                'baseGroups' => $groups,
                'baseProductSizes' => $productSizes,
                'sizesWithPrices' => $sizes,
                'chosenGroups' => $chosenGroups,
                'baseChosenCategorie' => $chosenCategorie,
                'errors' => [$failure],
            ]);
        }
        // validator
        return view('admin.editProduct', [
            'product' => $product,
            'baseCategories' => $categories,
            'baseGroups' => $groups,
            'baseProductSizes' => $productSizes,
            'sizesWithPrices' => $sizes,
            'chosenGroups' => $chosenGroups,
            'baseChosenCategorie' => $chosenCategorie,
            'errors' => $failure->errors(),
        ]);
    }
    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
            ],
            'priceForSize' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $price) {
                        if (is_numeric($price) || $price == null) {
                            continue;
                        }
                        $fail("Het $attribute mag alleen nummers bevatten.");
                    }
                }
            ],
            'custom_prices.*' => ['nullable', 'numeric',],
            'custom_sizes.*' => ['nullable', 'string'],
            'products_group-multiselect' => ['required', 'array'],
            'category' => ['required', 'string'],
            'af-submit-app-upload-images' => [
                'required',
                'file',
                'image',
            ],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Het naam veld moet ingevuld worden.',
            'name.string' => 'Het naam veld moet een tekst zijn.',
            'category.required' => 'Het Kleur categorie veld moet ingevuld worden.',
            'category.string' => 'Het Kleur categorie veld moet een tekst zijn.',
            'af-submit-app-upload-images.required' => 'Voeg een afbeelding toe.',
            'af-submit-app-upload-images.file' => 'Je probeert iets te uploaden dat geen bestand is.',
            'af-submit-app-upload-images.image' => 'Het geüploade bestand moet een afbeelding zijn.',
            'priceForSize.required' => 'Vul minimaal 1 prijs in voor de maat.',
            'priceForSize.array' => 'Het prijs per maat veld moet een array zijn.',
            'custom_prices.*.numeric' => 'Het aangepaste prijzen veld moet numeriek zijn.',
            'groups.required' => 'Geef aan bij welke groepen de functie hoort',
        ]);

        if ($validator->fails()) {
            return $this->goToAddProduct($validator);
        }

        $product = new ProductViewmodel();
        $product->setName($request->input('name'));
        $product->setCategory($request->input('category'));
        $product->image_path = $this->savePicture($request->file('af-submit-app-upload-images'), $product->getName());
        $product->setPriceForSize($request->input('priceForSize'));
        $product->addPriceForSize($request->input('custom_sizes'), $request->input('custom_prices'));
        $product->setGroups($request->input('products_group-multiselect'));
        $product->setPriceForSize(array_filter($product->priceForSize, function ($price) {
            return $price != null;
        }));
        $product->setGroups(array_filter($product->groups, function ($group) {
            return $group != null;
        }));

        if (empty($product->priceForSize) || empty($product->groups)) {
            $validator->errors()->add('priceForSize', 'Vul een prijs van een maat in.');
            return $this->goToAddProduct($validator);
        }

        DB::beginTransaction();
        try {
            $category = $this->categoryToId($product->getCategory());

            // Create the product with all attributes including image_path
            Product::create([
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
                $databaseProduct->productSizes()->attach(
                    $databaseProduct->id,
                    ['product_size_id' => ProductSize::where('size', $size)->first()->id, 'price' => $price]
                );
            }

            $groups = Group::all();
            foreach ($product->groups as $group) {
                if (!$groups->where('name', $group)->first()) {
                    dd($group);
                }
            }

            foreach ($product->groups as $group) {
                Product::where('name', $product->getName())->first()->groups()
                    ->attach(Group::where('name', $group)->first());
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return $this->productOverview();
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
