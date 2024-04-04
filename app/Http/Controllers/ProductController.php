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
        $productViewModel->category = $product->type->type;

        $groups = $product->groups()->pluck('name')->toArray();
        $productViewModel->groups = $groups;

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

    public function createProduct(Request $request)
    {
        $categories = ProductType::all()->select('id', 'type');
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
            'groups' => ['required', 'array'],
            'category' => [
                'required',
                'array',
                'max:1',
                function ($attribute, $value, $fail) use ($categories) {
                    if ($value[0] == null) {
                        $fail("Het categorie veld moet ingevuld worden.");
                    } else if ($categories->where('type', $value[0])->first() == null) {
                        $fail("$value[0] is geen geldige categorie.");
                    }
                }
            ],
            'af-submit-app-upload-images' => [
                'required',
                'file',
                'image',
            ],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Het naam veld moet ingevuld worden.',
            'name.string' => 'Het naam veld moet een tekst zijn.',
            'category.required' => 'Het categorie veld moet ingevuld worden.',
            'category.array' => 'Het categorie veld moet een lijst zijn.',
            'category.max:1' => 'Het categorie veld mag maar 1 category bevatten.',
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
        $product->setCategory($request->input('category')[0]);
        $product->setPicture($request->file('af-submit-app-upload-images'));
        $product->setPriceForSize($request->input('priceForSize'));
        $product->addPriceForSize($request->input('custom_sizes'), $request->input('custom_prices'));
        $product->setGroups($request->input('groups'));
        $product->description = $request->input('description');
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
            $category = $this->catagoryToId($product->getCategory());

            // Create the product with all attributes including image_path
            Product::create([
                'name' => $product->getName(),
                'discount' => 0,
                'product_type_id' => $category,
                'image_path' => $product->getPicture(),
                'description' => $product->description,
            ]);

            $sizes = ProductSize::all();
            foreach ($product->priceForSize as $size => $price) {
                if (!$sizes->where('size', $size)->first()) {
                    ProductSize::create(['size' => $size]);
                }
            }

            foreach ($product->priceForSize as $size => $price) {
                Product::where('name', $product->getName())->first()->productSizes()
                    ->attach(ProductSize::where('size', $size)->first(), ['price' => $price]);
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
