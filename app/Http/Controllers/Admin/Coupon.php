<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupons;

class Coupon extends Controller
{
    public function list(Request $request)
    {
        $query = Coupons::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('code', 'like', '%' . $searchTerm . '%');
        });
        $coupons = $query->orderBy('id', 'desc')->paginate(30);
        $data = [
            'active_page' => 'coupons',
            'coupons' => $coupons
        ];
        return view('admin.coupons', $data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'usage_limit' => 'nullable|integer|min:0'
        ], [
            'code.required' => 'Coupon code is required.',
            'code.unique' => 'Coupon code must be unique.',
            'type.required' => 'Coupon type is required.',
            'type.in' => 'Coupon type must be either "fixed" or "percentage".',
            'value.required' => 'Coupon value is required.',
            'value.numeric' => 'Coupon value must be a number.',
            'value.min' => 'Coupon value must be at least :min.',
            'valid_until.after_or_equal' => 'Valid until date must be after or equal to valid from date.',
            'usage_limit.integer' => 'Usage limit must be an integer.',
            'usage_limit.min' => 'Usage limit must be at least :min.'
        ]);
        Coupons::create($request->all());
        return redirect()->back()->with('success', 'A new coupon code has added.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:coupons,id'
        ], [
            'id.required' => 'Coupon ID is required.',
            'id.exists' => 'Invalid coupon selected.'
        ]);
        $coupon = Coupons::findOrFail($request->id);
        $coupon->delete();
        return redirect()->back()->with('success', 'Coupon has been successfully removed.');
    }
}