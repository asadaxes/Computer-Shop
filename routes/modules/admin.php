<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Generals;
use App\Http\Controllers\Admin\User;
use App\Http\Controllers\Admin\Brand;
use App\Http\Controllers\Admin\Categories;
use App\Http\Controllers\Admin\SubCategories;
use App\Http\Controllers\Admin\Product;
use App\Http\Controllers\Admin\Coupon;

Route::middleware('auth', 'verified', 'active', 'admin')->group(function () {
    Route::get('/admin/dashboard', [Generals::class, 'dashboard'])->name('admin_dashboard');

    Route::get('/admin/orders', [Product::class, 'orders'])->name('admin_orders');
    Route::post('/admin/orders/status/updater', [Product::class, 'orders_status_updater'])->name('admin_orders_status_updater');

    Route::get('/admin/users/list', [User::class, 'users_list'])->name('admin_users_list');
    Route::get('/admin/users/add', [User::class, 'users_add'])->name('admin_users_add');
    Route::post('/admin/users/add/handler', [User::class, 'users_add_handler'])->name('admin_users_add_handler');
    Route::get('/admin/users/view', [User::class, 'users_view'])->name('admin_users_view');
    Route::post('/admin/users/view/handler', [User::class, 'users_view_handler'])->name('admin_users_view_handler');
    Route::post('/admin/users/delete/account', [User::class, 'users_delete_account'])->name('admin_users_delete_account');

    Route::get('/admin/brands', [Brand::class, 'brands'])->name('admin_brands');
    Route::post('/admin/brands/add', [Brand::class, 'brands_add'])->name('admin_brands_add');
    Route::post('/admin/brands/remove', [Brand::class, 'brands_remove'])->name('admin_brands_remove');

    Route::get('/admin/category/list', [Categories::class, 'list'])->name('admin_category_list');
    Route::post('/admin/category/add', [Categories::class, 'add'])->name('admin_category_add');
    Route::post('/admin/category/edit/handler', [Categories::class, 'edit'])->name('admin_category_edit');
    Route::post('/admin/category/remove/handler', [Categories::class, 'delete'])->name('admin_category_delete');

    Route::get('/admin/sub-category/list', [SubCategories::class, 'list'])->name('admin_sub_category_list');
    Route::post('/admin/sub-category/add', [SubCategories::class, 'add'])->name('admin_sub_category_add');
    Route::post('/admin/sub-category/edit/handler', [SubCategories::class, 'edit'])->name('admin_sub_category_edit');
    Route::post('/admin/sub-category/remove/handler', [SubCategories::class, 'delete'])->name('admin_sub_category_delete');

    Route::get('/admin/products/list', [Product::class, 'list'])->name('admin_products_list');
    Route::get('/admin/products/add', [Product::class, 'add'])->name('admin_products_add');
    Route::post('/admin/products/add/handler', [Product::class, 'add_handler'])->name('admin_products_add_handler');
    Route::get('/admin/products/view', [Product::class, 'view'])->name('admin_products_view');
    Route::post('/admin/products/view/handler', [Product::class, 'view_handler'])->name('admin_products_view_handler');
    Route::post('/admin/products/remove/handler', [Product::class, 'delete'])->name('admin_products_delete');
    Route::get('/admin/products/recommends', [Product::class, 'recommends'])->name('admin_products_recommends');
    Route::post('/admin/products/recommends/updater', [Product::class, 'recommends_updater'])->name('admin_products_recommends_updater');
    Route::get('/admin/products/best-deals', [Product::class, 'best_deals'])->name('admin_products_best_deals');
    Route::post('/admin/products/best-deals/updater', [Product::class, 'best_deals_updater'])->name('admin_products_best_deals_updater');
    Route::get('/admin/products/flash-sale', [Product::class, 'flash_sale'])->name('admin_products_flash_sale');
    Route::post('/admin/products/flash-sale/updater', [Product::class, 'flash_sale_updater'])->name('admin_products_flash_sale_updater');
    Route::post('/admin/products/flash-sale/status/updater', [Product::class, 'flash_sale_status_updater'])->name('admin_products_flash_sale_status_updater');

    Route::get('/admin/coupons', [Coupon::class, 'list'])->name('admin_coupons');
    Route::post('/admin/coupons/add', [Coupon::class, 'add'])->name('admin_coupons_add');
    Route::post('/admin/coupons/remove', [Coupon::class, 'remove'])->name('admin_coupons_remove');

    Route::get('/admin/faq', [Generals::class, 'faq'])->name('admin_faq');
    Route::post('/admin/faq/add', [Generals::class, 'faq_add'])->name('admin_faq_add');
    Route::post('/admin/faq/edit', [Generals::class, 'faq_edit'])->name('admin_faq_edit');
    Route::post('/admin/faq/delete', [Generals::class, 'faq_delete'])->name('admin_faq_delete');

    Route::get('/admin/pages', [Generals::class, 'pages'])->name('admin_pages');
    Route::post('/admin/pages/add', [Generals::class, 'pages_add'])->name('admin_pages_add');
    Route::post('/admin/pages/edit', [Generals::class, 'pages_edit'])->name('admin_pages_edit');
    Route::post('/admin/pages/delete', [Generals::class, 'pages_delete'])->name('admin_pages_delete');

    Route::get('/admin/layout', [Generals::class, 'layout'])->name('admin_layout');
    Route::post('/admin/layout/update/slider', [Generals::class, 'layout_update_slider'])->name('admin_layout_update_slider');
    Route::get('/admin/layout/remove/slider', [Generals::class, 'layout_remove_slider'])->name('admin_layout_remove_slider');
    Route::post('/admin/layout/update/fp', [Generals::class, 'layout_update_fp'])->name('admin_layout_update_fp');
    Route::post('/admin/layout/update/container', [Generals::class, 'layout_update_container'])->name('admin_layout_update_container');
    Route::post('/admin/layout/update/parallax_banner', [Generals::class, 'layout_update_parallax_banner'])->name('admin_layout_update_parallax_banner');
    Route::post('/admin/layout/ac_list/add', [Generals::class, 'layout_ac_list_add'])->name('admin_layout_ac_list_add');
    Route::post('/admin/layout/ac_list/remove', [Generals::class, 'layout_ac_list_remove'])->name('admin_layout_ac_list_remove');

    Route::get('/admin/settings', [Generals::class, 'settings_general'])->name('admin_settings_general');
    Route::post('/admin/settings/general/updater', [Generals::class, 'settings_general_updater'])->name('admin_settings_general_updater');
    Route::get('/admin/settings/charges', [Generals::class, 'settings_charges'])->name('admin_settings_charges');
    Route::post('/admin/settings/charges/updater', [Generals::class, 'settings_charges_updater'])->name('admin_settings_charges_updater');
    Route::get('/admin/settings/env', [Generals::class, 'settings_env'])->name('admin_settings_env');
    Route::post('/admin/settings/env/updater', [Generals::class, 'settings_env_updater'])->name('admin_settings_env_updater');
});