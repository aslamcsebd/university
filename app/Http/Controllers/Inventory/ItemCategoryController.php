<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function index()
    {
        $categories = ItemCategory::withCount('items')->orderBy('name')->get();
        return view('inventory.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:item_categories,name',
            'description' => 'nullable|string|max:500',
        ]);
        ItemCategory::create($data);
        return back()->with('success', 'Category added.');
    }

    public function update(Request $request, ItemCategory $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:item_categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);
        $category->update($data);
        return back()->with('success', 'Category updated.');
    }

    public function destroy(ItemCategory $category)
    {
        if ($category->items()->exists()) {
            return back()->with('error', 'Cannot delete category with items.');
        }
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
