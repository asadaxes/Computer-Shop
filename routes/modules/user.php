<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth', 'active')->group(function () {
    Route::get('/my-account', [UserController::class, 'account'])->name('user_account');
    Route::post('/my-account/update', [UserController::class, 'account_update'])->name('user_account_update');
    Route::post('/my-account/update/img', [UserController::class, 'account_update_img'])->name('user_account_update_img');
    Route::post('/my-account/deletion', [UserController::class, 'account_delete'])->name('user_account_delete');
    Route::get('/my-account/change-password', [UserController::class, 'account_change_password'])->name('user_account_change_password');
    Route::post('/my-account/change-password/update', [UserController::class, 'account_change_password_update'])->name('user_account_change_password_update');
});

Route::middleware('auth', 'active', 'verified')->group(function () {
    Route::get('/my-account/orders', [UserController::class, 'orders'])->name('user_account_orders');
    Route::get('/my-account/wishlist', [UserController::class, 'wishlist'])->name('user_account_wishlist');
});