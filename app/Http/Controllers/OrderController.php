<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // GET
    public function overview(string $category)
    {
        $productCategory = $category;
        $products = OrderController::getAllproducts();

        return view('orders.overview', [
            'sizes' => OrderController::getSizes(),
            'productCategory' => $productCategory,
            'products' => $products
        ]);
    }

    public function product(string $id)
    {
        $product = OrderController::getProduct($id);

        return view('orders.product', [
            'sizes' => OrderController::getSizes(),
            'productCategory' => 'Not Implemented!',
            'product' => $product
        ]);
    }

    public function order()
    {
        $order = 1;
        $groups = OrderController::getGroups();

        return view('orders.order', [
            'order' => $order,
            'groups' => $groups
        ]);
    }

    // POST
    public function completeOrder(Request $request)
    {
        // $request->session()->flash('form_data', $request->all());

        // $validated = $request->validate([
        //     'email' => 'required|max:64',
        //     'lid-naam' => 'required|max:32',
        //     'postalCode' => 'required|max:32',
        //     'houseNumber' => 'required|max:32',
        //     'houseNumberAddition' => 'max:8',
        //     'streetname' => 'required|max:32',
        //     'cityName' => 'required|max:32',
        // ]);

        dd($request, $request->input('email'));
    }

    // DELETE in pull request!!!!!!!!!!!!!!!!!!!
    public static function getProduct($id) {
        $product = new Product;
        switch ($id) {
            case 0:
                $product->id = 0;
                $product->name = 'Appel';
                $product->price = 12.34;
                $product->salePrice = 11.22;
                $product->imageUri = 'https://placehold.co/150x150';
                break;
            case 1:
                $product->id = 1;
                $product->name = 'Banaan';
                $product->price = 12.34;
                $product->salePrice = 11.22;
                $product->imageUri = 'https://placehold.co/150x150';
            break;
            case 2:
                $product->id = 2;
                $product->name = 'C';
                $product->price = 12.34;
                $product->salePrice = 11.22;
                $product->imageUri = 'https://placehold.co/150x150';
            break;
            case 3:
                $product->id = 3;
                $product->name = 'Draaitol';
                $product->price = 12.34;
                $product->salePrice = 11.22;
                $product->imageUri = 'https://placehold.co/150x150';
            break;
            case 4:
                $product->id = 4;
                $product->name = 'Eten';
                $product->price = 12.34;
                $product->salePrice = 11.22;
                $product->imageUri = 'https://placehold.co/150x150';
            break;
            case 5:
                $product->id = 5;
                $product->name = 'Fornuis';
                $product->price = 12.34;
                $product->salePrice = 11.22;
                $product->imageUri = 'https://placehold.co/150x150';
            break;
            case 6:
                $product->id = 6;
                $product->name = 'Goud';
                $product->price = 12.34;
                $product->salePrice = 11.22;
                $product->imageUri = 'https://placehold.co/150x150';
            break;
            case 7:
                $product->id = 7;
                $product->name = 'Huis';
                $product->price = 12.34;
                $product->salePrice = 11.22;
                $product->imageUri = 'https://placehold.co/150x150';
            break;
        }

        return $product;
    }

    public static function getAllproducts() {
        return [
            OrderController::getProduct(0),
            OrderController::getProduct(1),
            OrderController::getProduct(2),
            OrderController::getProduct(3),
            OrderController::getProduct(4),
            OrderController::getProduct(5),
            OrderController::getProduct(6),
            OrderController::getProduct(7)
        ];
    }

    public static function getSizes()
    {
        return [
            'S',
            'M',
            'L',
            'XL'
        ];
    }

    public static function getGroups()
    {
        return [
            'Bevers',
            'Bevertjes',
            'Beverinos',
            'Bee-heel-vers'
        ];
    }
}
