<?php

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
}) -> name('home');

Route::get(__('navbar.cart'), function () {
    return view('customer.cart');
}) -> name('cart');

Route::get(__('navbar.checkout'), function () {
    return view('customer.checkout');
}) -> name('checkout');

Route::get(__('navbar.manage_accounts'), function () {
    return view('admin.accounts');
}) -> name('manage-accounts');

Route::get(__('navbar.manage_products'), function () {
    return view('admin.products');
}) -> name('manage-products');

// TODO: Add a route for the login page
Route::get(__('navbar.login'), function () {
    return view('customer.home');
}) -> name('login');

// Orders
Route::get('/product-categorie/{category?}', [OrderController::class, 'overview'])
    ->name('orders.overview')
    ->defaults('category', 'endpoint not implemented');

Route::get('/product/{id}', [OrderController::class, 'product'])
    ->name('orders.product');
Route::get('/products', function() {
    return view('orders.overview');
});

Route::get('/bestelling', [OrderController::class, 'order'])
    ->name('orders.order');
Route::post('/complete-order', [OrderController::class, 'completeOrder'])
    ->name('orders.complete-order');

Route::get('/winkelmand', [ShoppingCartController::class, 'index'])
    ->name('shoppingcart.index');

// Shopping Cart
Route::post('/shoppingcart/insert/{id}', [ShoppingCartController::class, 'insert'])
    ->name('shoppingcart.insert');
Route::post('/shoppingcart/update', [ShoppingCartController::class, 'update'])
    ->name('shoppingcart.update');
