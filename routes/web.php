<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
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

Route::get('/', [OrderController::class, 'index'])
    ->name('home');

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
    Route::get(__('navbar.manage_accounts'), [AccountsController::class, 'index'])
        ->name('manage-accounts');

    Route::get(__('navbar.manage_products'), function () {
        return view('admin.products');
    })->name('manage-products');

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

    Route::get('warning-toast-no-admins', function () {
        return redirect()
            ->route('manage-accounts')
            ->with([
                'toast-type' => 'warning',
                'toast-message' => __('toast.warning-no-admins')
            ]);
    });
});

Route::get(__('navbar.logout'), function () {
    return redirect()
        ->route('home')
        ->with([
            'toast-type' => 'success',
            'toast-message' => __('auth.logout-success')
        ]);
})->name('logout');

/// Orders
Route::get(__('route.overview') . '/{category?}', [OrderController::class, 'overview'])
    ->name('orders.overview')
    ->defaults('category', '');


Route::get(__('route.product') . '/{name}/{groupName?}', [OrderController::class, 'product'])
    ->name('orders.product')
    ->defaults('groupName', '');

// Shopping Cart
Route::get(__('route.shopping-cart'), [ShoppingCartController::class, 'index'])
    ->name('shoppingcart.index');

// Checkout
Route::get(__('route.checkout'), [OrderController::class, 'order'])
    ->name('orders.order');
Route::post('/complete-order', [OrderController::class, 'completeOrder'])
    ->name('orders.complete-order');
Route::get(__('route.completed-order'), [OrderController::class, 'completedOrder'])
    ->name('orders.completed');

// Shopping Cart
Route::post('/shoppingcart/insert/{id}', [ShoppingCartController::class, 'insert'])
    ->name('shoppingcart.insert');
Route::post('/shoppingcart/update', [ShoppingCartController::class, 'update'])
    ->name('shoppingcart.update');

// Testing
Route::get('/test', [TestController::class, 'index'])
    ->name('test.index');
Route::post('/test/send-test-mail', [TestController::class, 'test_send_test_mail'])
    ->name('test.send-test-mail');
Route::get('/test/authenticate', [TestController::class, 'authenticate'])
    ->name('test.authenticate');
Route::get("/auth/google/callback", [TestController::class, 'gmailAuthCallback'])
->name('test.gmail-auth-callback');
