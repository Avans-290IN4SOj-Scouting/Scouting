<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get(__('navbar.register'), [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('registerpost');

    Route::get(__('navbar.login'), [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post(__('navbar.login'), [AuthenticatedSessionController::class, 'store'])
        ->name('loginpost');
});

Route::middleware('auth')->group(function () {
    Route::post(__('auth.logout'), [AuthenticatedSessionController::class, 'destroy'])
        ->name('logoutpost');
});
