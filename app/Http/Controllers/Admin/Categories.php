<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class Categories extends Controller
{
    public function list(Request $request)
    {
        $query = Category::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        });
        $categories_data = $query->paginate(30);
        $data = [
            'active_page' => 'category',
            'categories_data' => $categories_data
        ];
        return view('admin.category', $data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ], [
            'name.required' => 'Category name is required.'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100'
        ], [
            'id.required' => 'Category ID is required.',
            'id.exists' => 'Invalid category ID.',
            'name.required' => 'Category name is required.'
        ]);
        $category = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->save();
    
        return redirect()->back()->with('success', 'Category updated successfully');
    }
    
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ], [
            'id.required' => 'Category ID is required'
        ]);
        $category = Category::findOrFail($request->id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}