<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShoppingCartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('customer.home');
})->name('home');

Route::get(__('navbar.cart'), function () {
    return view('customer.cart');
})->name('cart');

Route::get(__('navbar.cart'), function () {
    return view('customer.cart');
}) -> name('cart');

Route::get(__('navbar.checkout'), function () {
    return view('customer.checkout');
})->name('checkout');

Route::get(__('navbar.manage_accounts'), function () {
    return view('admin.accounts');
})->name('manage-accounts');





Route::get(__('navbar.login'), function () {
    return view('customer.home');
})->name('login');

/*// TODO: Temporary route to test toasts
Route::get('/test', function () {
    return redirect()
        ->route('home')
        ->with([
            'toast-type' => 'error',
            'toast-message' => 'This is a test error message'
        ]);
});
}) -> name('login');*/

// Products beheer
Route::get(__('navbar.manage_products'),
    [ProductController::class, 'productOverview'])->name('manage-products');

Route::post('/products/create', [ProductController::class, 'createProduct'])->name('product.createProduct');

Route::get(__('navbar.manage_addProduct'),
    [ProductController::class, 'goToAddProduct'])->name('manage-addProduct');


Route::get('/product/{id}/edit', [ProductController::class, 'editProduct'])->name('product.EditProduct');



// Orders
Route::get('/product-categorie/{category?}/{size?}', [OrderController::class, 'overview'])
    ->name('orders.overview')
    ->defaults('category', 'bevers')
    ->defaults('size', 'S');

Route::get('/product/{id}/{size?}', [OrderController::class, 'product'])
    ->name('orders.product')
    ->defaults('size', 'S');
Route::get('/products', function() {
    return view('orders.overview');
});

Route::get('/bestelling', [OrderController::class, 'order'])
    ->name('orders.order');
Route::post('/complete-order', [OrderController::class, 'completeOrder'])
    ->name('orders.complete-order');

// https://gyazo.com/aad381774efb9fc0f6eb40bb5584c908
Route::get('/winkelwagen', [ShoppingCartController::class, 'index'])
    ->name('shoppingcart.index');

// Shopping Cart
Route::post('/shoppingcart/insert/{id}', [ShoppingCartController::class, 'insert'])
    ->name('shoppingcart.insert');
Route::post('/shoppingcart/update', [ShoppingCartController::class, 'update'])
    ->name('shoppingcart.update');
