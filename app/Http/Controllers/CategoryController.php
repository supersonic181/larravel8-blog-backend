<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryController
{
    public function createCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:categories,name']
        ]);

        $slug = Str::of($validated['name'])->slug('-');

        return Category::create([
            "name" => $validated['name'],
            "slug" => $slug
        ]);
    }

    public function updateCategory(Category $category, Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', Rule::unique('categories')->ignore($category->id)],
        ]);

        $slug = Str::of($validated['name'])->slug('-');

        $category->update([
            "name" => $validated['name'],
            "slug" => $slug
        ]);

        return $category;
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return response()->json("Successfully Deleted");
    }

    public function getCategory()
    {
        return Category::all();
    }
}
