<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Brands;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Pages;
use App\Models\Settings;
use App\Models\Orders;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $view->with([
                'brands' => Brands::all(),
                'categories' => Category::all(),
                'sub_categories' => SubCategory::all(),
                'pages' => Pages::all(),
                'settings' => Settings::first(),
                'incomplete_orders' => Orders::whereIn('deliver_status', ['placed', 'preparing', 'shipping'])->where('status', 'success')->distinct('order_id')->count('order_id')
            ]);
        });
    }
}