<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::get('/', [GeneralController::class, 'home'])->name('home');
Route::get('/faq', [GeneralController::class, 'faq'])->name('faq');
Route::get('/p/{slug}', [GeneralController::class, 'page_details'])->name('page_details');
Route::get('/track-my-order', [GeneralController::class, 'track_order'])->name('track_order');
Route::get('/brands', [GeneralController::class, 'brands_list'])->name('brands_list');
Route::get('/best_deals', [GeneralController::class, 'best_deals'])->name('best_deals');