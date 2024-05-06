<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\ManageProductsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderDetailsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GmailController;
use App\Http\Controllers\ManageOrdersController;
use App\Http\Controllers\TestController;

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
        Route::get('/', [ProfileController::class, 'index'])
            ->name('index');

        Route::post('/', [ProfileController::class, 'update'])
            ->name('update');
    });

    // Order cancelling testing page (remove when orderDetails is made)
    Route::get('/orderDetails/{orderId}', [OrderDetailsController::class, 'orderDetails'])
        ->name('orders-user.details-order');
    Route::post('/orderDetails/cancelOrder', [OrderDetailsController::class, 'cancelOrder'])
        ->name('orders-user.cancel-order');
});

Route::get(__('route.logout'), function () {
    return redirect()
        ->route('home')
        ->with([
            'toast-type' => 'success',
            'toast-message' => __('auth/auth.logout-success')
        ]);
})->name('logout');

Route::middleware('role:admin')->group(function () {
    Route::prefix(__('route.manage'))->name('manage.')->group(function () {
        Route::prefix(__('route.accounts'))->name('accounts.')->group(function () {
            Route::get('/', [AccountsController::class, 'index'])
                ->name('index');

            Route::get(__('route.filter'), [AccountsController::class, 'filter'])
                ->name('filter');

            Route::post(__('route.update_roles'), [AccountsController::class, 'updateRoles'])
                ->name('update.roles');

            Route::get('warning-toast-accounts', function () {
                return redirect()
                    ->route('manage.accounts.index')
                    ->with([
                        'toast-type' => 'warning',
                        'toast-message' => __('toast/messages.warning-accounts')
                    ]);
            });

            Route::get('warning-toast-no-admins', function () {
                return redirect()
                    ->route('manage.accounts.index')
                    ->with([
                        'toast-type' => 'warning',
                        'toast-message' => __('toast/messages.warning-no-admins')
                    ]);
            });
        });

        //TODO: Move to be better suited controller
        Route::get(__('navbar.manage_products'), [ManageProductsController::class, 'index'])
            ->name('products');

        Route::prefix(__('route.orders'))->name('orders.')->group(function () {
            Route::get('/', [ManageOrdersController::class, 'index'])
                ->name('index');

            Route::get(__('route.order-details') . '/{id}', [ManageOrdersController::class, 'orderDetails'])
                ->name('order');

            Route::get(__('route.filter'), [ManageOrdersController::class, 'filter'])
                ->name('filter');

            // In geval dat '/{id}' breekt, vervang deze met de uigecommente route hieronder
            // Route::post(__('route.cancel-order') . '/{id}', [ManageOrdersController::class, 'cancelOrder'])
            //     ->name('cancel-order');
            Route::post('/{id}', [ManageOrdersController::class, 'cancelOrder'])
                ->name('cancel-order');
        });

        Route::get(__('navbar.manage_products'), function () {
            return view('admin.products');
        })->name('products');
    });
});

Route::prefix(__('route.products'))->name('orders.')->group(function () {
    Route::get(__('route.overview') . '/{category?}', [OrderController::class, 'overview'])
        ->name('overview');

    Route::get('/{name}/{groupName?}', [OrderController::class, 'product'])
        ->name('product');
});

Route::prefix(__('route.order'))->name('orders.')->group(function () {
    Route::prefix(__('route.checkout'))->name('checkout.')->group(function () {
        Route::get('/', [OrderController::class, 'order'])
            ->name('order');
        Route::post(__('route.complete_order'), [OrderController::class, 'completeOrder'])
            ->name('complete-order');
        Route::get(__('route.complete_order'), [OrderController::class, 'completedOrder'])
            ->name('completed');
    });

    Route::prefix(__('route.cart'))->name('shoppingcart.')->group(function () {
        Route::get('/', [ShoppingCartController::class, 'index'])
            ->name('index');
        Route::post(__('route.update'), [ShoppingCartController::class, 'update'])
            ->name('update');
    });
});

// Gmail Testing
Route::get('/test', [TestController::class, 'index'])
    ->name('test.index');
Route::post('/test/send-test-mail', [TestController::class, 'test_send_test_mail'])
    ->name('test.send-test-mail');

// Gmail
Route::get('/gmail/authenticate', [GmailController::class, 'authenticate'])
    ->name('gmail.authenticate');
Route::get("/auth/google/callback", [GmailController::class, 'gmailAuthCallback'])
    ->name('gmail.auth-callback');
