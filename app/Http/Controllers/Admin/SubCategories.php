<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;


class SubCategories extends Controller
{
    public function list(Request $request)
    {
        $query = SubCategory::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        });
        $sub_categories_data = $query->paginate(30);

        $data = [
            'active_page' => 'sub_category',
            'sub_categories_data' => $sub_categories_data
        ];
        return view('admin.sub_category', $data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100'
        ], [
            'category_id.required' => 'Please select a category',
            'category_id.exists' => 'The selected category does not exist',
            'name.required' => 'Sub-category name is required',
            'name.max' => 'You have reached the maximum length for the sub-category name'
        ]);

        $category = Category::findOrFail($request->category_id);
        $subCategory = new SubCategory();
        $subCategory->category_id = $category->id;
        $subCategory->name = $request->name;
        $subCategory->save();
        return redirect()->back()->with('success', 'Sub-Category created successfully');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'id' => 'required'
        ], [
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Invalid category selected',
            'name.required' => 'sub-category name is required',
            'name.max' => 'you have reached the maximum length',
            'id.required' => 'Sub-Category ID is required'
        ]);

        $subCategory = SubCategory::findOrFail($request->id);

        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->save();
        return redirect()->back()->with('success', 'Sub-Category update successfully');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ], [
            'id.required' => 'Sub-Category ID is required'
        ]);
        $sub_category = SubCategory::findOrFail($request->id);
        $sub_category->delete();
        return redirect()->back()->with('success', 'Sub-Category deleted successfully');
    }
}