<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get(__('route.register'), [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('registerpost');

    Route::get(__('route.login'), [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post(__('route.login'), [AuthenticatedSessionController::class, 'store'])
        ->name('loginpost');
});

Route::middleware('auth')->group(function () {
    Route::post('/destroy', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logoutpost');
});
