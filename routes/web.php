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
})->name('home');

Route::get(__('navbar.cart'), function () {
    return view('customer.cart');
})->name('cart');

Route::get(__('navbar.checkout'), function () {
    return view('customer.checkout');
})->name('checkout');

Route::get(__('navbar.manage_accounts'), [AccountsController::class, 'index'])
   -> name('manage-accounts');

Route::post(__('navbar.manage_accounts'), [AccountsController::class, 'updateRoles'])
    ->name('manage-accounts.updateRoles');

Route::get('warning-toast-accounts', function () {
    return redirect()
        ->route('manage-accounts')
        ->with([
           'toast-type' => 'warning',
           'toast-message' => __('toast.warning-accounts')
        ]);
});

Route::get(__('navbar.manage_products'), function () {
    return view('admin.products');
})->name('manage-products');

// TODO: Add a route for the login page
Route::get(__('navbar.login'), function () {
    return view('customer.home');
})->name('login');

// TODO: Temporary route to test toasts
Route::get('/test', function () {
    return redirect()
        ->route('home')
        ->with([
            'toast-type' => 'error',
            'toast-message' => 'This is a test error message'
        ]);
});
