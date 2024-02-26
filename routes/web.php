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
    return view('welcome');
});

// Orders
Route::get('/product-categorie/{category?}', [OrderController::class, 'overview'])
    ->name('orders.overview')
    ->defaults('category', 'endpoint not implemented');

Route::get('/product/{id}', [OrderController::class, 'product'])
    ->name('orders.product');
Route::get('/products', function() {
    return view('orders.overview');
});

Route::get('/winkelmand', [ShoppingCartController::class, 'index'])
    ->name('shoppingcart.index');

// Shopping Cart
Route::post('/shoppingcart/insert/{id}', [ShoppingCartController::class, 'insert'])
    ->name('shoppingcart.insert');
