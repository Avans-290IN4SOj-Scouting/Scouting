<?php

use App\Http\Controllers\ProfileController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get(__('navbar.cart'), function () {
    return view('customer.cart');
})->name('cart');

Route::get(__('navbar.checkout'), function () {
    return view('customer.checkout');
})->name('checkout');

Route::middleware('role:admin')->group(function () {
    Route::get(__('navbar.manage_accounts'), function () {
        return view('admin.accounts');
    })->name('manage-accounts');

    Route::get(__('navbar.manage_products'), function () {
        return view('admin.products');
    })->name('manage-products');
});

Route::get('/logout', function () {
    return redirect()
        ->route('home')
        ->with([
            'toast-type' => 'success',
            'toast-message' => __('auth.logout-success')
        ]);
})->name('logout');
