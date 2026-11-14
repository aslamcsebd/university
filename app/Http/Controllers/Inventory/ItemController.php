<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Store;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['category', 'store']);
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) $query->where('category_id', $request->category);
        if ($request->filled('store'))    $query->where('store_id', $request->store);

        $items      = $query->latest()->paginate(20)->withQueryString();
        $categories = ItemCategory::orderBy('name')->get();
        $stores     = Store::orderBy('name')->get();
        return view('inventory.item-list', compact('items', 'categories', 'stores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'   => 'required|exists:item_categories,id',
            'store_id'      => 'required|exists:stores,id',
            'name'          => 'required|string|max:255',
            'code'          => 'nullable|string|max:50|unique:items,code',
            'unit'          => 'required|string|max:50',
            'min_threshold' => 'nullable|numeric|min:0',
            'is_consumable' => 'boolean',
            'description'   => 'nullable|string',
        ]);
        Item::create($data);
        return back()->with('success', 'Item added.');
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'category_id'   => 'required|exists:item_categories,id',
            'store_id'      => 'required|exists:stores,id',
            'name'          => 'required|string|max:255',
            'code'          => 'nullable|string|max:50|unique:items,code,' . $item->id,
            'unit'          => 'required|string|max:50',
            'min_threshold' => 'nullable|numeric|min:0',
            'is_consumable' => 'boolean',
            'description'   => 'nullable|string',
        ]);
        $item->update($data);
        return back()->with('success', 'Item updated.');
    }

    public function destroy(Item $item)
    {
        if ($item->issues()->exists()) {
            return back()->with('error', 'Cannot delete item with issue history.');
        }
        $item->delete();
        return back()->with('success', 'Item deleted.');
    }
}
