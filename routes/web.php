<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShoppingCartController;
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

require __DIR__ . '/auth.php';

Route::get('/', [OrderController::class, 'index'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('update');
    });

    Route::get(__('navbar.logout'), function () {
        return redirect()
            ->route('home')
            ->with([
                'toast-type' => 'success',
                'toast-message' => __('auth.logout-success')
            ]);
    })->name('logout');
});

Route::middleware('role:admin')->group(function () {
    Route::prefix('/manage')->name('manage.')->group(function () {
        Route::prefix('/accounts')->name('accounts.')->group(function () {
            Route::get('/', [AccountsController::class, 'index'])
                ->name('index');

            Route::post('/update-roles', [AccountsController::class, 'updateRoles'])
                ->name('update.roles');

            Route::get('warning-toast-accounts', function () {
                return redirect()
                    ->route('manage.accounts.index')
                    ->with([
                        'toast-type' => 'warning',
                        'toast-message' => __('toast.warning-accounts')
                    ]);
            });

            Route::get('warning-toast-no-admins', function () {
                return redirect()
                    ->route('manage.accounts.index')
                    ->with([
                        'toast-type' => 'warning',
                        'toast-message' => __('toast.warning-no-admins')
                    ]);
            });
        });

        Route::get(__('navbar.manage_products'), function () {
            return view('admin.products');
        })->name('products');
    });
});

Route::prefix('orders')->name('orders.')->group(function () {
    Route::get(__('route.overview') . '/{category?}', [OrderController::class, 'overview'])
        ->name('overview');

    Route::get(__('route.product') . '/{name}/{groupName?}', [OrderController::class, 'product'])
        ->name('product');

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get(__('route.checkout'), [OrderController::class, 'order'])
            ->name('order');
        Route::post('/complete-order', [OrderController::class, 'completeOrder'])
            ->name('complete-order');
        Route::get(__('route.completed-order'), [OrderController::class, 'completedOrder'])
            ->name('completed');
    });

    Route::prefix('shoppingcart')->name('shoppingcart.')->group(function () {
        Route::get(__('route.shopping-cart'), [ShoppingCartController::class, 'index'])
            ->name('index');
        Route::post('/update', [ShoppingCartController::class, 'update'])
            ->name('update');
    });
});
