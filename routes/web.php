<?php

use App\Http\Controllers\AccountsController;
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

Route::get('/cart', function () {
    return view('customer.cart');
}) -> name('cart');

Route::get('/checkout', function () {
    return view('customer.checkout');
}) -> name('checkout');

Route::get('/manageaccounts', [AccountsController::class, 'index']) 
   -> name('manage-accounts');


Route::get('/manageproducts', function () {
    return view('admin.products');
}) -> name('manage-products');
