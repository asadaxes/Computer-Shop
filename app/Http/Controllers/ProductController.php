<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Wishlist;
use App\Models\Products;
use App\Models\Payments;
use App\Models\Orders;
use App\Models\Invoices;
use App\Models\Coupons;
use App\Models\Settings;

class ProductController extends Controller
{
    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $sslc = new SslCommerzNotification();
        $order_details = Payments::where('tran_id', $tran_id)->first();
        if ($order_details->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);
            if ($validation) {
                Payments::where('tran_id', $tran_id)->update(['status' => 'Complete']);
                Orders::where('order_id', $order_details->order_id)->update(['status' => 'success']);
                $invoice = new Invoices();
                $invoice->user_id = Auth::id();
                $invoice->order_id = $order_details->order_id;
                $invoice->save();
                $orders = Orders::where('order_id', $order_details->order_id)->get();
                foreach ($orders as $order) {
                    $product = Products::findOrFail($order->product_id);
                    $product->quantity = $product->quantity - $order->quantity;
                    $product->save();
                }
                session()->flash('payment_successful_clean_cart', true);
                return redirect()->route('product_checkout_order_complete');
            }
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            Payments::where('tran_id', $tran_id)->update(['status' => 'Complete']);
            Orders::where('order_id', $order_details->order_id)->update(['status' => 'success']);
            $invoice = new Invoices();
            $invoice->user_id = Auth::id();
            $invoice->order_id = $order_details->order_id;
            $invoice->save();
            $orders = Orders::where('order_id', $order_details->order_id)->get();
                foreach ($orders as $order) {
                    $product = Products::findOrFail($order->product_id);
                    $product->quantity = $product->quantity - $order->quantity;
                    $product->save();
                }
                session()->flash('payment_successful_clean_cart', true);
                return redirect()->route('user_account_orders')->with('success', 'Your order is already placed.');
        } else {
            Orders::where('order_id', $order_details->order_id)->update(['status' => 'failed']);
            return redirect()->route('product_checkout')->with('error', 'Invalid Transaction.');
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order_details = Payments::where('tran_id', $tran_id)->first();
        if ($order_details->status == 'Pending') {
            Payments::where('tran_id', $tran_id)->update(['status' => 'Failed']);
            Orders::where('order_id', $order_details->order_id)->update(['status' => 'failed']);
            return redirect()->route('product_checkout')->with('error', 'Transaction has failed.');
        } elseif ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            return redirect()->route('user_account_orders')->with('success', 'Transaction is already successful.');
        } else {
            return redirect()->route('product_checkout')->with('error', 'Transaction is invalid.');
        }
    }    

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order_details = Payments::where('tran_id', $tran_id)->first();
        if ($order_details->status == 'Pending') {
            Payments::where('tran_id', $tran_id)->update(['status' => 'Canceled']);
            Orders::where('order_id', $order_details->order_id)->update(['status' => 'canceled']);
            return redirect()->route('product_checkout')->with('error', 'Transaction is canceled.');
        } elseif ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            return redirect()->route('user_account_orders')->with('success', 'Transaction is already successful.');
        } else {
            return redirect()->route('product_checkout')->with('error', 'Transaction is invalid.');
        }
    }    

    public function ipn(Request $request)
    {
        if ($request->input('tran_id')) {
            $tran_id = $request->input('tran_id');
            $order_details = Payments::where('tran_id', $tran_id)->first();
            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $request->input('amount'), $request->input('currency'));
                if ($validation) {
                    Payments::where('tran_id', $tran_id)->update(['status' => 'Processing']);
                    Orders::where('order_id', $order_details->order_id)->update(['status' => 'success']);
                    session()->flash('payment_successful_clean_cart', true);
                    return redirect()->route('user_account_orders')->with('success', 'Transaction is successfully completed.');
                }
            } elseif ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
                return redirect()->route('user_account_orders')->with('success', 'Transaction is already successful.');
            } else {
                return redirect()->route('product_checkout')->with('error', 'Transaction is invalid.');
            }
        } else {
            return redirect()->route('product_checkout')->with('error', 'Invalid data.');
        }
    }


    public function wishlist_updater(Request $request)
    {
        $product_id = $request->query('id');
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:products,id'
        ], [
            'id.required' => 'Product ID is required.',
            'id.exists' => 'The selected product does not exist.'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user_id = auth()->id();
        $wishlistItem = Wishlist::where('user_id', $user_id)->where('product_id', $product_id)->first();
        if ($wishlistItem) {
            $wishlistItem->delete();
            return redirect()->back()->with('success', 'Product removed from wishlist.');
        } else {
            Wishlist::create([
                'user_id' => $user_id,
                'product_id' => $product_id
            ]);
            return redirect()->back()->with('success', 'Product added to wishlist.');
        }
    }

    public function wishlist_remover($id)
    {
        $user_id = auth()->id();
        $wishlistItem = Wishlist::where('user_id', $user_id)->where('id', $id)->first();
        if ($wishlistItem) {
            $wishlistItem->delete();
            return redirect()->back()->with('success', 'Product removed from wishlist.');
        }
        return redirect()->back()->with('error', 'Product not found in wishlist.');
    }

    public function cart()
    {
        return view('general.product_cart');
    }

    public function checkout()
    {
        return view('general.product_checkout');
    }

    public function checkout_handler(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'zip_code' => 'required|string',
            'payment_method' => 'required|in:pay_with_ssl,cash_on_delivery',
            'products' => 'required',
            'coupon_code' => 'nullable'
        ], [
            'first_name.required' => 'Full name is required.',
            'last_name.required' => 'La name is required.',
            'email.required' => 'Email is required.',
            'phone.required' => 'Phone number is required.',
            'address.required' => 'Shipping address is required.',
            'city.required' => 'City is required.',
            'country.required' => 'Country is required.',
            'zip_code.required' => 'Zip code is required.',
            'payment_method.required' => 'The payment method is required.',
            'payment_method.in' => 'Invalid payment method selected. Please choose either digital payment or cash on delivery.',
            'products.required' => 'Product data was missing! please try to remove and re-add the products into cart.'
        ]);

        $shipping_address = [
            "first_name" => $validatedData['first_name'],
            "last_name" => $validatedData['last_name'],
            "email" => $validatedData['email'],
            "phone" => $validatedData['phone'],
            "address" => $validatedData['address'],
            "city" => $validatedData['city'],
            "country" => $validatedData['country'],
            "zip_code" => $validatedData['zip_code']
        ];

        $products = json_decode($request->products, true);

        foreach ($products as $product) {
            $pd = Products::findOrFail($product['id']);
            if ($product['quantity'] > $pd->quantity) {
                return redirect()->route('product_cart')->with('error', 'Insufficient stock for product: ' . $pd->title);
            }
        }

        $order_id = '#' . Str::upper(Str::random(12));

        $settings = Settings::first();
        $delivery_charge = 0;
        if($validatedData['city'] === 'Dhaka'){
            $delivery_charge = $settings->delivery_charge_inside;
        }else{
            $delivery_charge = $settings->delivery_charge_outside;
        }
        $tax = $settings->tax;

        $total_amount = 0;
        foreach ($products as $product) {
            $pd = Products::findOrFail($product['id']);
            $total_amount += $pd['sale_price'] * $product['quantity'];
        }
        $total_amount += $delivery_charge + $tax;

        if (!empty($validatedData['coupon_code'])) {
            $coupon = Coupons::where('code', $validatedData['coupon_code'])->first();
            if ($coupon && $coupon->valid_until >= now() && $coupon->usage_limit > $coupon->usage_count) {
                if ($coupon->type === 'percentage') {
                    $discountAmount = ($coupon->value / 100) * $total_amount;
                } elseif ($coupon->type === 'fixed') {
                    $discountAmount = $coupon->value;
                }
                $total_amount -= $discountAmount;

                if ($total_amount < 0) {
                    $total_amount = 0;
                }

                $coupon->usage_count += 1;
                $coupon->save();
            }
        }

        foreach ($products as $product) {
            $order = new Orders();
            $order->order_id = $order_id;
            $order->product_id = $product['id'];
            $order->user_id = auth()->user()->id;
            $order->amount = $total_amount;
            $order->quantity = $product['quantity'];
            $order->delivery_method = $validatedData['payment_method'];
            $order->shipping_address = json_encode($shipping_address);
            $order->save();
        }

        if($validatedData['payment_method'] === 'pay_with_ssl'){
            $post_data = array();        
            $post_data['total_amount'] = $total_amount;
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = uniqid();

            $post_data['cus_name'] = $validatedData['first_name'] . " " . $validatedData['last_name'];
            $post_data['cus_email'] = $validatedData['email'];
            $post_data['cus_add1'] = $validatedData['address'];
            $post_data['cus_phone'] = $validatedData['phone'];

            $post_data['ship_name'] = "No Shipping";
            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "PnA";
            $post_data['product_category'] = "PnA";
            $post_data['product_profile'] = "non-physical-goods";

            $post_data['value_a'] = "ref001";
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";

            Payments::create([
                'user_id' => auth()->user()->id,
                'order_id' => $order_id,
                'amount' => $total_amount,
                'currency' => $post_data['currency'],
                'tran_id' => $post_data['tran_id'],
                'status' => 'Pending'
            ]);

            $sslc = new SslCommerzNotification();
            $payment_options = $sslc->makePayment($post_data, 'hosted');

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            }            
        }else if($validatedData['payment_method'] === 'cash_on_delivery'){
            Orders::where('order_id', $order_id)->update(['status' => 'success']);
            $invoice = new Invoices();
            $invoice->user_id = auth()->user()->id;
            $invoice->order_id = $order_id;
            $invoice->save();
            foreach ($products as $product) {
                $pd = Products::findOrFail($product['id']);
                $pd->quantity = $pd->quantity - $product['quantity'];
                $pd->save();
            }
            session()->flash('payment_successful_clean_cart', true);
            return redirect()->route('product_checkout_order_complete');
        }
    }

    public function checkout_order_complete()
    {
        return view('general.product_checkout_done');
    }

    public function product_view($slug)
    {
        $product = Products::where('slug', $slug)->first();
        $related_products = Products::where('category_id', $product->category_id)->where('id', '!=', $product->id)->limit(15)->get();
        $data = [
            'product' => $product,
            'related_products' => $related_products
        ];
        return view('general.product_view', $data);
    }

    public function search_query(Request $request)
    {
        $query = Products::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('condition', 'like', '%' . $searchTerm . '%')
                ->orWhere('sale_price', 'like', '%' . $searchTerm . '%')
                ->orWhere('regular_price', 'like', '%' . $searchTerm . '%')
                ->orWhere('tags', 'like', '%' . $searchTerm . '%')
                ->orWhere('featured', 'like', '%' . $searchTerm . '%')
                ->orWhere('specification', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                    $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('subcategory', function ($subcategoryQuery) use ($searchTerm) {
                    $subcategoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('brand', function ($categoryQuery) use ($searchTerm) {
                    $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                });
                
        });
        $products = $query->orderBy('id', 'desc')->paginate(30);
        $data = [
            'products' => $products
        ];
        return view('general.search_query', $data);
    }

    public function search_query_live(Request $request)
    {
        $query = $request->input('query');
        if($query) {
            $products = Products::where('title', 'LIKE', "%{$query}%")
                ->orWhereJsonContains('tags', $query)
                ->take(10)
                ->get(['id', 'title', 'slug', 'sale_price', 'images'])
                ->map(function($product) {
                    $images = json_decode($product->images, true);
                    $product->image = Storage::url($images[0]);
                    return $product;
                });
            return response()->json($products);
        }
        return response()->json([]);
    }

    public function coupon_checker(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);    
        $coupon = Coupons::where('code', $request->coupon_code)->first();
        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code!'
            ]);
        }
        if ($coupon->valid_until && $coupon->valid_until < now()) {
            return response()->json([
                'valid' => false,
                'message' => 'This coupon code has expired!'
            ]);
        }
        if ($coupon->usage_limit && $coupon->usage_limit <= $coupon->usage_count) {
            return response()->json([
                'valid' => false,
                'message' => 'This coupon code has reached its usage limit!'
            ]);
        }
        $discountInfo = '';
        if ($coupon->type === 'percentage') {
            $discountInfo = "{$coupon->value}%";
        } elseif ($coupon->type === 'fixed') {
            $discountInfo = "৳{$coupon->value}";
        }
        return response()->json([
            'valid' => true,
            'message' => "Coupon applied! You received {$discountInfo} discount.",
            'code' => $coupon->code,
            'value' => $coupon->value,
            'type' => $coupon->type
        ]);
    }
}