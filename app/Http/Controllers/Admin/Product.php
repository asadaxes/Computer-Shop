<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Products;
use App\Models\Recommends;
use App\Models\BestDeals;
use App\Models\FlashSale;
use App\Models\Orders;


class Product extends Controller
{
    public function list(Request $request)
    {
        $query = Products::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                ->orWhere('condition', 'like', '%' . $searchTerm . '%')
                ->orWhere('sale_price', 'like', '%' . $searchTerm . '%')
                ->orWhere('regular_price', 'like', '%' . $searchTerm . '%')
                ->orWhereJsonContains('tags', $searchTerm)
                ->orWhereJsonContains('featured', $searchTerm)
                ->orWhereJsonContains('specification', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('key', 'like', '%' . $searchTerm . '%')
                             ->orWhere('value', 'like', '%' . $searchTerm . '%');
                });
                
        });
        $products = $query->orderBy('id', 'desc')->paginate(30);
        $data = [
            'active_page' => 'products_list',
            'products' => $products
        ];
        return view('admin.products_list', $data);
    }

    public function add()
    {
        $data = [
            'active_page' => 'products_add'
        ];
        return view('admin.products_add', $data);
    }

    public function add_handler(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'sku' => 'required|string',
            'featured' => 'nullable',
            'description' => 'nullable',
            'specification' => 'nullable',
            'tags' => 'required',
            'condition' => 'nullable|string|in:New,Used,Refurbished',
            'quantity' => 'required|integer|min:1',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'category_id' => 'required|integer|exists:categories,id',
            'regular_price' => 'nullable|numeric',
            'sale_price' => 'required|numeric',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'images' => 'required'
        ], [
            'title.required' => 'The product title is required.',
            'title.string' => 'The product title must be a string.',
            'title.max' => 'The product title must not exceed 150 characters.',
            'sku.required' => 'The product sku is required.',
            'description.required' => 'The product description is required.',
            'tags.required' => 'The tags field is required.',
            'condition.string' => 'The product condition must be a string.',
            'condition.in' => 'The selected product condition is invalid.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
            'brand_id.integer' => 'The brand ID must be an integer.',
            'brand_id.exists' => 'The selected brand does not exist.',
            'category_id.required' => 'The category is required.',
            'category_id.integer' => 'The category ID must be an integer.',
            'category_id.exists' => 'The selected category does not exist.',
            'regular_price.numeric' => 'The regular price must be a number.',
            'sale_price.required' => 'The sale price is required.',
            'sale_price.numeric' => 'The sale price must be a number.',
            'meta_title.string' => 'The meta title must be a string.',
            'meta_description.string' => 'The meta description must be a string.',
            'images.required' => 'At least add a product image.'
        ]);

        $images = [];
        $imageDataArray = json_decode($request->input('images'), true);
        foreach ($imageDataArray as $imageData) {
            if (strpos($imageData, 'data:image') === 0) {
                $extension = explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                $imageName = time() . Str::random(10) . '.' . $extension;
                Storage::disk('public')->put('products/' . $imageName, base64_decode(preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $imageData)));
                $images[] = 'products/' . $imageName;
            } else {
                $images[] = $imageData;
            }
        }

        $product = new Products();
        $product->title = $request->title;
        $product->sku = $request->sku;
        $product->featured = $request->featured;
        $product->description = $request->description;
        $product->specification = $request->specification;
        $product->tags = json_encode(array_map('trim', explode(',', $request->tags)));;
        $product->condition = $request->condition;
        $product->quantity = $request->quantity;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->images = json_encode($images);
        $product->save();
        return redirect()->route('admin_products_list')->with('success', 'A new product has added.');
    }

    public function view()
    {
        try {
            $id = request()->query('id');
            $product = Products::findOrFail($id);
            $data = [
                'active_page' => 'products_view',
                'product' => $product
            ];
            return view('admin.products_view', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin_products_view');
        }
    }

    public function view_handler(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:150',
            'sku' => 'required|string',
            'featured' => 'nullable',
            'description' => 'nullable',
            'specification' => 'nullable',
            'tags' => 'required',
            'condition' => 'nullable|string|in:New,Used,Refurbished',
            'quantity' => 'required|integer',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'category_id' => 'required|integer|exists:categories,id',
            'regular_price' => 'nullable|numeric',
            'sale_price' => 'required|numeric',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'images' => 'required'
        ], [
            'product_id.required' => 'Product ID is required.',
            'title.required' => 'The product title is required.',
            'title.string' => 'The product title must be a string.',
            'title.max' => 'The product title must not exceed 150 characters.',
            'sku.required' => 'The product sku is required.',
            'tags.required' => 'The tags field is required.',
            'condition.string' => 'The product condition must be a string.',
            'condition.in' => 'The selected product condition is invalid.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'brand_id.integer' => 'The brand ID must be an integer.',
            'brand_id.exists' => 'The selected brand does not exist.',
            'category_id.required' => 'The category is required.',
            'category_id.integer' => 'The category ID must be an integer.',
            'category_id.exists' => 'The selected category does not exist.',
            'regular_price.numeric' => 'The regular price must be a number.',
            'sale_price.required' => 'The sale price is required.',
            'sale_price.numeric' => 'The sale price must be a number.',
            'meta_title.string' => 'The meta title must be a string.',
            'meta_description.string' => 'The meta description must be a string.',
            'images.required' => 'At least add a product image.'
        ]);

        $product = Products::findOrFail($request->product_id);
        $product->title = $request->title;
        $product->sku = $request->sku;
        $product->featured = json_decode($request->featured);
        $product->description = $request->description;
        $product->specification = json_decode($request->specification);
        $product->tags = json_encode(array_map('trim', explode(',', $request->tags)));;
        $product->condition = $request->condition;
        $product->quantity = $request->quantity;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        $images = [];
        $imageDataArray = json_decode($request->input('images'), true);
        foreach ($imageDataArray as $imageData) {
            if (strpos($imageData, 'data:image') === 0) {
                $extension = explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                $imageName = time() . Str::random(10) . '.' . $extension;
                Storage::disk('public')->put('products/' . $imageName, base64_decode(preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $imageData)));
                $images[] = 'products/' . $imageName;
            } else {
                $images[] = $imageData;
            }
        }
        $product->images = json_encode($images);
        $product->save();
        return redirect()->back()->with('success', 'Product details has updated.');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ], [
            'product_id.required' => 'Product ID is required',
            'product_id.exists' => 'Invalid product ID'
        ]);
        $product = Products::findOrFail($request->product_id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function recommends(Request $request)
    {
        $recommendedProductIds = Recommends::pluck('product_id');
        $query = Products::whereNotIn('id', $recommendedProductIds);
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                ->orWhere('condition', 'like', '%' . $searchTerm . '%')
                ->orWhere('sale_price', 'like', '%' . $searchTerm . '%')
                ->orWhere('regular_price', 'like', '%' . $searchTerm . '%')
                ->orWhereJsonContains('tags', $searchTerm)
                ->orWhereJsonContains('featured', $searchTerm)
                ->orWhereJsonContains('specification', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('key', 'like', '%' . $searchTerm . '%')
                             ->orWhere('value', 'like', '%' . $searchTerm . '%');
                });
        });
        $all_products = $query->orderBy('id', 'desc')->paginate(30);
        $recommended_products = Products::whereIn('id', $recommendedProductIds)->get();
        $data = [
            'active_page' => 'products_recommends',
            'all_products' => $all_products,
            'recommended_products' => $recommended_products
        ];
        return view('admin.products_recommends', $data);
    }

    public function recommends_updater(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ], [
            'id.required' => 'Product ID is required.'
        ]);
        $recommendedProduct = Recommends::where('product_id', $request->id)->first();
        if ($recommendedProduct) {
            $recommendedProduct->delete();
            return redirect()->back()->with('success', 'Product removed from recommendations.');
        } else {
            Recommends::create(['product_id' => $request->id]);
            return redirect()->back()->with('success', 'Product added to recommendations.');
        }
    }

    public function best_deals(Request $request)
    {
        $bestDealsProductIds = BestDeals::pluck('product_id')->toArray();
        $flashSaleProductIds = FlashSale::pluck('products')->flatten()->toArray();
        $excludeIds = array_merge($bestDealsProductIds, $flashSaleProductIds);
        $query = Products::whereNotIn('id', $excludeIds);
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                ->orWhere('condition', 'like', '%' . $searchTerm . '%')
                ->orWhere('sale_price', 'like', '%' . $searchTerm . '%')
                ->orWhere('regular_price', 'like', '%' . $searchTerm . '%')
                ->orWhereJsonContains('tags', $searchTerm)
                ->orWhereJsonContains('featured', $searchTerm)
                ->orWhereJsonContains('specification', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('key', 'like', '%' . $searchTerm . '%')
                             ->orWhere('value', 'like', '%' . $searchTerm . '%');
                });
        });
        $all_products = $query->orderBy('id', 'desc')->paginate(30);
        $best_deals_products = Products::whereIn('id', $bestDealsProductIds)->get();
        $data = [
            'active_page' => 'products_best_deals',
            'all_products' => $all_products,
            'best_deals_products' => $best_deals_products
        ];
        return view('admin.products_best_deals', $data);
    }    

    public function best_deals_updater(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ], [
            'id.required' => 'Product ID is required.'
        ]);
        $bestDealsProduct = BestDeals::where('product_id', $request->id)->first();
        if ($bestDealsProduct) {
            $bestDealsProduct->delete();
            return redirect()->back()->with('success', 'Product removed from best deals.');
        } else {
            BestDeals::create(['product_id' => $request->id]);
            return redirect()->back()->with('success', 'Product added to best deals.');
        }
    }

    public function flash_sale(Request $request)
    {
        $flashSaleProductIds = FlashSale::pluck('products')->flatten()->toArray();
        $bestDealsProductIds = BestDeals::pluck('product_id')->toArray();
        $excludeIds = array_merge($flashSaleProductIds, $bestDealsProductIds);
        $query = Products::whereNotIn('id', $excludeIds);
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                ->orWhere('condition', 'like', '%' . $searchTerm . '%')
                ->orWhere('sale_price', 'like', '%' . $searchTerm . '%')
                ->orWhere('regular_price', 'like', '%' . $searchTerm . '%')
                ->orWhereJsonContains('tags', $searchTerm)
                ->orWhereJsonContains('featured', $searchTerm)
                ->orWhereJsonContains('specification', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('key', 'like', '%' . $searchTerm . '%')
                            ->orWhere('value', 'like', '%' . $searchTerm . '%');
                });
        });
        $all_products = $query->orderBy('id', 'desc')->paginate(30);
        $flash_sale_products = Products::whereIn('id', $flashSaleProductIds)->get();
        $flash_sale = FlashSale::where('status', 'Active')->first();
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
        $data = [
            'active_page' => 'products_flash_sale',
            'all_products' => $all_products,
            'flash_sale_products' => $flash_sale_products,
            'flash_sale' => $flash_sale_status
        ];
        return view('admin.products_flash_sale', $data);
    }
    
    public function flash_sale_updater(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ], [
            'id.required' => 'Product ID is required.'
        ]);
        $productId = $request->id;
        $flashSale = FlashSale::first();
        if ($flashSale) {
            $products = $flashSale->products ?? [];
            if (is_string($products)) {
                $products = json_decode($products, true);
            }
            if (in_array($productId, $products)) {
                $products = array_diff($products, [$productId]);
                $flashSale->products = array_values($products);
                $flashSale->save();
                return redirect()->back()->with('success', 'Product removed from flash sale.');
            } else {
                $products[] = $productId;
                $flashSale->products = $products;
                $flashSale->save();
                return redirect()->back()->with('success', 'Product added to flash sale.');
            }
        } else {
            FlashSale::create([
                'products' => [$productId],
                'from_date' => now(),
                'to_date' => now()->addDays(7),
                'status' => 'Upcoming'
            ]);
            return redirect()->back()->with('success', 'Product added to flash sale.');
        }
    }

    public function flash_sale_status_updater(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'status' => 'required|in:Upcoming,Active,Expired'
        ], [
            'from_date.required' => 'Start date is required.',
            'to_date.required' => 'End date is required.',
            'status.required' => 'Status is required.'
        ]);

        $flashSale = FlashSale::first();
        if ($flashSale) {
            $flashSale->update([
                'from_date' => $request->input('from_date'),
                'to_date' => $request->input('to_date'),
                'status' => $request->input('status')
            ]);
        }

        return redirect()->back()->with('success', 'Flash Sale updated successfully.');
    }

    public function orders(Request $request)
    {
        $query = Orders::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('order_id', 'like', '%' . $searchTerm . '%')
                ->orWhere('amount', 'like', '%' . $searchTerm . '%')
                ->orWhere('deliver_status', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('user', function ($q) use ($searchTerm) {
                    $q->where('first_name', 'like', '%' . $searchTerm . '%');
                    $q->where('last_name', 'like', '%' . $searchTerm . '%');
                });
        });
        $orders = $query->where('status', 'success')
                        ->orderByRaw("CASE deliver_status
                                    WHEN 'placed' THEN 1
                                    WHEN 'preparing' THEN 2
                                    WHEN 'shipping' THEN 3
                                    WHEN 'delivered' THEN 4
                                    ELSE 4
                                    END")
                        ->orderBy('issued_at', 'desc')
                        ->paginate(10);
        $data = [
            'active_page' => 'orders',
            'orders' => $orders
        ];
        return view('admin.orders', $data);
    }

    public function orders_status_updater(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'deliver_status' => 'required|in:placed,preparing,shipping,delivered'
        ], [
            'order_id.required' => 'Order ID is required',
            'deliver_status.required' => 'Status is required',
            'deliver_status.in' => 'Invalid status provided'
        ]);
        $updated = Orders::where('order_id', $request->order_id)->update(['deliver_status' => $request->deliver_status]);
        if ($updated) {
            return redirect()->back()->with('success', 'Status updated successfully.');
        } else {
            return redirect()->back()->with('error', 'No orders found to update.');
        }
    }
}