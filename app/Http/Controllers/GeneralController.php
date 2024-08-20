<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Products;
use App\Models\BestDeals;
use App\Models\Recommends;
use App\Models\FlashSale;
use App\Models\Orders;
use App\Models\Faq;
use App\Models\Pages;
use App\Models\Layout;
use App\Models\AccessoriesCategory;

class GeneralController extends Controller
{
    public function home()
    {
        $latest_products = Products::orderBy('publish_date', 'desc')->limit(5)->get();
        $best_selling_products = Orders::select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->where('status', 'success')
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();
        $best_sales = [];
        foreach ($best_selling_products as $sale) {
            $product = Products::find($sale->product_id);
            if ($product) {
                $product->total_sales = $sale->total_sales;
                $best_sales[] = $product;
            }
        }
        $recommended_products_ids = Recommends::pluck('product_id')->toArray();
        $recommended_products = Products::whereIn('id', $recommended_products_ids)->get();

//        $flash_sale_products = [];
//        $flash_sale = FlashSale::where('status', 'Active')->first();
//        if ($flash_sale) {
//            $flash_sale_product_ids = $flash_sale->products;
//            $flash_sale_products = Products::whereIn('id', $flash_sale_product_ids)->get();
//        }

        $flash_sale_products = [];
        $flash_sale = FlashSale::where('status', 'Active')->first();
        if ($flash_sale) {
            $flash_sale_product_ids = json_decode($flash_sale->products, true); // Convert to an array
            if (is_array($flash_sale_product_ids)) {
                $flash_sale_products = Products::whereIn('id', $flash_sale_product_ids)->get();
            }
        }


        $flash_sale_status = FlashSale::first();
        if ($flash_sale) {
            if ($flash_sale->from_date && Carbon::now()->gt($flash_sale->from_date)) {
                $flash_sale->status = 'Active';
                $flash_sale->save();
            } elseif ($flash_sale->to_date && Carbon::now()->gt($flash_sale->to_date)) {
                $flash_sale->status = 'Expired';
                $flash_sale->save();
            }
        }

        $layout = Layout::first();
        $ac_list = AccessoriesCategory::all();
        $data = [
            'latest_products' => $latest_products,
            'best_sales' => $best_sales,
            'recommended_products' => $recommended_products,
            'flash_sale_products' => $flash_sale_products,
            'flash_sale' => $flash_sale_status,
            'layout' => $layout,
            'ac_list' => $ac_list
        ];
        return view('general.home', $data);
    }

    public function faq()
    {
        $faqs = Faq::all();
        return view('general.faq', ['faqs' => $faqs]);
    }

    public function page_details($slug)
    {
        $page = Pages::where('slug', $slug)->first();
        $data = [
            'page' => $page
        ];
        return view('general.page', $data);
    }

    public function track_order(Request $request)
    {
        $order = null;
        if ($request->has('order_id')) {
            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,order_id'
            ], [
                'order_id.required' => 'Order ID is required.',
                'order_id.exists' => 'Invalid order ID.'
            ]);
            $order = Orders::where('order_id', $validatedData['order_id'])->firstOrFail();
        }
        return view('general.track_order', compact('order'));
    }

    public function brands_list()
    {
        return view('general.brands');
    }

    public function best_deals()
    {
        $products = BestDeals::orderBy('id', 'desc')->paginate(30);
        return view('general.best_deals', ['products' => $products]);
    }
}
