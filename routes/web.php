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
    ->defaults('category', 'endpoint not implemented');

// Shopping Cart
Route::post('/shoppingcart/insert/{id}', [ShoppingCartController::class, 'insert'])
    ->name('shoppingcart.insert');
