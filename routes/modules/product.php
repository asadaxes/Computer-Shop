<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/my-cart', [ProductController::class, 'cart'])->name('product_cart');
Route::get('/product/{slug}', [ProductController::class, 'product_view'])->name('product_view');
Route::get('/search', [ProductController::class, 'search_query'])->name('search_query');
Route::get('/search/live', [ProductController::class, 'search_query_live'])->name('search_query_live');

Route::middleware('auth', 'active', 'verified')->group(function () {
    Route::post('/secure-pay/success', [ProductController::class, 'success'])->name('payment_success');
    Route::post('/secure-pay/fail', [ProductController::class, 'fail'])->name('payment_fail');
    Route::post('/secure-pay/cancel', [ProductController::class, 'cancel'])->name('payment_cancel');
    Route::post('/secure-pay/ipn', [ProductController::class, 'ipn'])->name('payment_ipn');

    Route::get('/product/wishlist/updater', [ProductController::class, 'wishlist_updater'])->name('product_wishlist_updater');
    Route::get('/product/wishlist/remover/{id}', [ProductController::class, 'wishlist_remover'])->name('product_wishlist_remover');
    Route::get('/my-cart/checkout', [ProductController::class, 'checkout'])->name('product_checkout');
    Route::post('/my-cart/checkout/handler', [ProductController::class, 'checkout_handler'])->name('product_checkout_handler');
    Route::get('/my-cart/checkout/order-complete', [ProductController::class, 'checkout_order_complete'])->name('product_checkout_order_complete');
    Route::get('/my-cart/clear-payment-success-session', function () {
        session()->forget('payment_successful_clean_cart');
        return response()->json(['message' => 'Session cleared']);
    })->name('clear_payment_success_session');
    Route::post('/couple-validity-check', [ProductController::class, 'coupon_checker'])->name('product_coupon_checker');
});