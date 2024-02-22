<?php

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
