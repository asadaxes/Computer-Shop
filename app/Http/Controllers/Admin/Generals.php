<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Users;
use App\Models\Payments;
use App\Models\Brands;
use App\Models\Pages;
use App\Models\Faq;
use App\Models\Settings;
use App\Models\Layout;
use App\Models\AccessoriesCategory;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Products;
use App\Models\Coupons;
use App\Models\Orders;
use App\Models\FlashSale;
use App\Models\BestDeals;
use App\Models\Recommends;


class Generals extends Controller
{
    public function dashboard()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $payments = Payments::whereMonth('issued_at', $currentMonth)
                            ->whereYear('issued_at', $currentYear)
                            ->get();
        $orders = Orders::whereMonth('issued_at', $currentMonth)
                        ->whereYear('issued_at', $currentYear)
                        ->get();
        $numDaysInMonth = Carbon::now()->daysInMonth;
        $paymentsByDay = array_fill(0, $numDaysInMonth, 0);
        $ordersByDay = array_fill(0, $numDaysInMonth, 0);
        foreach ($payments as $payment) {
            $day = Carbon::parse($payment->issued_at)->day - 1;
            $paymentsByDay[$day] += $payment->amount;
        }
        foreach ($orders as $order) {
            $day = Carbon::parse($order->issued_at)->day - 1;
            $ordersByDay[$day] += 1;
        }
        $payWithSslCount = Orders::whereMonth('issued_at', $currentMonth)
                            ->whereYear('issued_at', $currentYear)
                            ->where('delivery_method', 'pay_with_ssl')
                            ->sum('amount');
        $cashOnDeliveryCount = Orders::whereMonth('issued_at', $currentMonth)
                                ->whereYear('issued_at', $currentYear)
                                ->where('delivery_method', 'cash_on_delivery')
                                ->sum('amount');
        $data = [
            'active_page' => 'dashboard',
            'total_users' => Users::count(),
            'total_products' => Products::count(),
            'total_flash_sale' => FlashSale::count(),
            'total_best_deals' => BestDeals::count(),
            'total_recommends' => Recommends::count(),
            'total_brands' => Brands::count(),
            'total_category' => Category::count(),
            'total_sub_category' => SubCategory::count(),
            'total_coupons' => Coupons::count(),
            'paymentsByDay' => $paymentsByDay,
            'ordersByDay' => $ordersByDay,
            'payWithSslCount' => $payWithSslCount,
            'cashOnDeliveryCount' => $cashOnDeliveryCount,
            'recent_payments' => Payments::orderBy('issued_at', 'desc')->limit(10)->get()
        ];
        return view('admin.dashboard', $data);
    }

    public function pages(Request $request)
    {
        $query = Pages::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        });
        $pages = $query->paginate(10);
        $data = [
            'active_page' => 'pages',
            'pages' => $pages
        ];
        return view('admin.pages', $data);
    }

    public function pages_add(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required'
        ], [
            'name.required' => 'The title is required.',
            'name.string' => 'The title must be a string.',
            'name.max' => 'The title may not be greater than 255 characters.',
            'content.required' => 'The content is required.'
        ]);
        $page = new Pages();
        $page->name = $validatedData['name'];
        $page->content = $validatedData['content'];
        $page->save();
        return redirect()->back()->with('success', 'Page added successfully.');
    }

    public function pages_edit(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:pages,id',
            'name' => 'required|string|max:255',
            'content' => 'required'
        ], [
            'id.exists' => 'The selected page does not exist.',
            'name.required' => 'The title is required.',
            'name.string' => 'The title must be a string.',
            'name.max' => 'The title may not be greater than 255 characters.',
            'content.required' => 'The content is required.'
        ]);
        $page = Pages::findOrFail($validatedData['id']);
        $page->name = $validatedData['name'];
        $page->content = $validatedData['content'];
        $page->save();
        return redirect()->back()->with('success', 'Page updated successfully.');
    }

    public function pages_delete(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:pages,id'
        ], [
            'id.exists' => 'The selected page does not exist.'
        ]);
        $page = Pages::findOrFail($validatedData['id']);
        $page->delete();
        return redirect()->back()->with('success', 'Page deleted successfully.');
    }

    public function faq(Request $request)
    {
        $query = Faq::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('question', 'like', '%' . $searchTerm . '%');
        });
        $faqs = $query->paginate(10);
        $data = [
            'active_page' => 'faq',
            'faqs' => $faqs
        ];
        return view('admin.faq', $data);
    }

    public function faq_add(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required'
        ], [
            'question.required' => 'The question is required.',
            'question.string' => 'The question must be a string.',
            'question.max' => 'The question may not be greater than 255 characters.',
            'answer.required' => 'The answer is required.'
        ]);
        $faq = new Faq();
        $faq->question = $validatedData['question'];
        $faq->answer = $validatedData['answer'];
        $faq->save();
        return redirect()->back()->with('success', 'FAQ added successfully.');
    }

    public function faq_edit(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:faqs,id',
            'question' => 'required|string|max:255',
            'answer' => 'required'
        ], [
            'id.exists' => 'The selected faq does not exist.',
            'question.required' => 'The question is required.',
            'question.string' => 'The question must be a string.',
            'question.max' => 'The question may not be greater than 255 characters.',
            'answer.required' => 'The answer is required.'
        ]);
        $faq = Faq::findOrFail($validatedData['id']);
        $faq->question = $validatedData['question'];
        $faq->answer = $validatedData['answer'];
        $faq->save();
        return redirect()->back()->with('success', 'FAQ updated successfully.');
    }

    public function faq_delete(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:faqs,id'
        ], [
            'id.exists' => 'The selected faq does not exist.'
        ]);
        $page = Faq::findOrFail($validatedData['id']);
        $page->delete();
        return redirect()->back()->with('success', 'FAQ deleted successfully.');
    }

    public function settings_general()
    {
        $data = [
            'active_page' => 'general'
        ];
        return view('admin.settings_general', $data);
    }

    public function settings_general_updater(Request $request)
    {
        $validatedData = $request->validate([
            'title_site' => 'required|string|max:255',
            'title_admin' => 'required|string|max:255',
            'footer_copyright' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'contact_address' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'ga_id' => 'nullable|string|max:50',
            'meta_author' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'social_ids' => 'required|string'
        ], [
            'title_site.required' => 'Site title is required.',
            'title_site.string' => 'Site title must be a string.',
            'title_site.max' => 'Site title may not be greater than 255 characters.',
            'title_admin.required' => 'Admin title is required.',
            'title_admin.string' => 'Admin title must be a string.',
            'title_admin.max' => 'Admin title may not be greater than 255 characters.',
            'contact_address.max' => 'Contact address may not be greater than 255 characters.',
            'contact_phone.max' => 'Contact phone may not be greater than 20 characters.',
            'contact_email.email' => 'Contact email must be a valid email address.',
            'contact_email.max' => 'Contact email may not be greater than 255 characters.',
            'ga_id.max' => 'Google Analytics ID may not be greater than 50 characters.',
            'meta_author.max' => 'Meta author may not be greater than 255 characters.',
            'social_ids.required' => 'At least add a social link.'
        ]);

        if ($request->hasFile('favicon')) {
            $logoPath = $request->file('favicon')->store('public/settings');
            $validatedData['favicon'] = $logoPath;
        }
        if ($request->hasFile('logo_site')) {
            $logoPath = $request->file('logo_site')->store('public/settings');
            $validatedData['logo_site'] = $logoPath;
        }
        if ($request->hasFile('logo_admin')) {
            $logoPath = $request->file('logo_admin')->store('public/settings');
            $validatedData['logo_admin'] = $logoPath;
        }

        $settings = Settings::first();
        $settings->update($validatedData);
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function settings_charges()
    {
        $data = [
            'active_page' => 'charge'
        ];
        return view('admin.settings_charge', $data);
    }

    public function settings_charges_updater(Request $request)
    {
        $validatedData = $request->validate([
            'delivery_charge_inside' => 'required',
            'delivery_charge_outside' => 'required',
            'tax' => 'required'
        ], [
            'delivery_charge_inside.required' => 'Delivery charge inside dhaka is required.',
            'delivery_charge_outside.required' => 'Delivery charge for outside of dhaka is required.',
            'tax.required' => 'Tax amount is requiredl.'
        ]);

        $settings = Settings::first();
        $settings->update($validatedData);
        return redirect()->back()->with('success', 'Save changes successfully.');
    }

    public function settings_env()
    {
        $envContent = File::get(base_path('.env'));
        $data = [
            'active_page' => 'env',
            'envContent' => $envContent
        ];
        return view('admin.settings_env', $data);
    }

    public function settings_env_updater(Request $request)
    {
        $request->validate([
            'data' => 'required'
        ]);
        File::put(base_path('.env'), $request->input('data'));
        return redirect()->route('admin_settings_env')->with('success', 'Environment file updated successfully.');
    }

    public function layout()
    {
        $layout = Layout::first();
        $ac_list = AccessoriesCategory::all();
        $data = [
            'active_page' => 'layout',
            'layout' => $layout,
            'ac_list' => $ac_list
        ];
        return view('admin.layout', $data);
    }

    public function layout_update_slider(Request $request)
    {
        $layout = Layout::first();
        $existingSliders = json_decode($request->input('sliders', '[]'), true);
        if($request->hasFile('new_sliders')) {
            $file = $request->file('new_sliders');
            $path = $file->store('layout', 'public');
            $newSlider = 'layout/' . basename($path);
            $existingSliders[] = $newSlider;
            $layout->header_sliders = json_encode($existingSliders);
            $layout->save();
    
            return redirect()->back()->with('success', 'Slider updated successfully.');
        }
        return redirect()->back()->with('error', 'No file was uploaded.');
    }

    public function layout_remove_slider(Request $request)
    {
        $layout = Layout::first();
        $existingSliders = json_decode($layout->header_sliders, true);
        if (($key = array_search($request->query('slider'), $existingSliders)) !== false) {
            unset($existingSliders[$key]);
        }
        $layout->header_sliders = json_encode(array_values($existingSliders));
        $layout->save();
        return redirect()->back()->with('success', 'Slider removed successfully.');
    }

    public function layout_update_fp(Request $request)
    {
        $layout = Layout::first();
        if ($request->hasFile('fp_img_1')) {
            $path1 = $request->file('fp_img_1')->store('layout', 'public');
            $layout->fp_img_1 = $path1;
        }
        if ($request->hasFile('fp_img_2')) {
            $path2 = $request->file('fp_img_2')->store('layout', 'public');
            $layout->fp_img_2 = $path2;
        }
        $layout->fp_text_1 = $request->input('fp_text_1');
        $layout->fp_text_2 = $request->input('fp_text_2');
        $layout->save();
        return redirect()->back()->with('success', 'Front page layout updated successfully.');
    }

    public function layout_update_container(Request $request)
    {
        $validatedData = $request->validate([
            'container_1_h' => 'required|string|max:255',
            'container_1_p' => 'required|string|max:255',
            'container_2_h' => 'required|string|max:255',
            'container_2_p' => 'required|string|max:255',
            'container_3_h' => 'required|string|max:255',
            'container_3_p' => 'required|string|max:255'
        ]);
        $containerData = [
            [
                'h' => $validatedData['container_1_h'],
                'p' => $validatedData['container_1_p']
            ],
            [
                'h' => $validatedData['container_2_h'],
                'p' => $validatedData['container_2_p']
            ],
            [
                'h' => $validatedData['container_3_h'],
                'p' => $validatedData['container_3_p']
            ]
        ];
        $layout = Layout::first();
        $layout->container = json_encode($containerData);
        $layout->save();
        return redirect()->back()->with('success', 'Container updated successfully.');
    }

    public function layout_update_parallax_banner(Request $request)
    {
        $layout = Layout::first();
        if ($request->hasFile('parallax_banner')) {
            $request->validate([
                'parallax_banner' => 'required|image'
            ]);
            if ($layout->parallax_banner && Storage::exists($layout->parallax_banner)) {
                Storage::delete($layout->parallax_banner);
            }
            $path = $request->file('parallax_banner')->store('layout', 'public');
            $layout->parallax_banner = $path;
            $layout->save();
            return redirect()->back()->with('success', 'Parallax banner updated successfully.');
        }
        return redirect()->back()->with('error', 'Please upload a valid image.');
    }

    public function layout_ac_list_add(Request $request)
    {
        $request->validate([
            'icon' => 'required|image',
            'name' => 'required|string|max:255',
        ], [
            'icon.required' => 'The icon field is required.',
            'icon.image' => 'The icon must be an image.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
        ]);
        $path = $request->file('icon')->store('accessories', 'public');
        $accessoryCategory = new AccessoriesCategory();
        $accessoryCategory->name = $request->input('name');
        $accessoryCategory->icon = $path;
        $accessoryCategory->save();
        return redirect()->back()->with('success', 'New category has added successfully.');
    }

    public function layout_ac_list_remove(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:accessories_categories,id'
        ], [
            'id.required' => 'The category ID is required.',
            'id.exists' => 'The selected category does not exist.'
        ]);
        $category = AccessoriesCategory::findOrFail($request->id);
        $category->delete();
        return redirect()->back()->with('success', 'Category removed successfully.');
    }
}