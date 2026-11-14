<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemStock;
use App\Models\ItemIssue;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['category','store'])->latest();
        if ($request->filled('search'))   { $query->where('name','like','%'.$request->search.'%'); }
        if ($request->filled('category')) { $query->where('category_id',$request->category); }
        $items      = $query->paginate(20)->withQueryString();
        $categories = ItemCategory::orderBy('name')->get();
        $stores     = Store::orderBy('name')->get();
        $lowStock   = Item::whereRaw('quantity <= min_threshold')->count();
        return view('inventory.index', compact('items','categories','stores','lowStock'));
    }

    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'category_id'   => 'required|exists:item_categories,id',
            'store_id'      => 'required|exists:stores,id',
            'name'          => 'required|string|max:255',
            'code'          => 'nullable|string|max:50|unique:items,code',
            'unit'          => 'required|string|max:50',
            'min_threshold' => 'nullable|numeric|min:0',
            'is_consumable' => 'boolean',
        ]);
        $validated['is_consumable'] = $request->boolean('is_consumable', true);
        Item::create($validated);
        return back()->with('success', 'Item added.');
    }

    public function stockIn(Request $request)
    {
        $validated = $request->validate([
            'item_id'       => 'required|exists:items,id',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'quantity'      => 'required|numeric|min:0.01',
            'unit_cost'     => 'nullable|numeric|min:0',
            'purchase_date' => 'required|date',
            'invoice_no'    => 'nullable|string|max:100',
        ]);
        $validated['total_cost']  = ($validated['unit_cost'] ?? 0) * $validated['quantity'];
        $validated['received_by'] = auth()->id();
        ItemStock::create($validated);
        Item::findOrFail($validated['item_id'])->increment('quantity', $validated['quantity']);
        return back()->with('success', 'Stock added successfully.');
    }

    public function issueItem(Request $request)
    {
        $validated = $request->validate([
            'item_id'              => 'required|exists:items,id',
            'quantity'             => 'required|numeric|min:0.01',
            'issued_to_id'         => 'nullable|string',
            'issued_to_type'       => 'required|in:staff,student,department',
            'purpose'              => 'nullable|string',
            'expected_return_date' => 'nullable|date|after:today',
        ]);

        $item = Item::findOrFail($validated['item_id']);
        if ($item->quantity < $validated['quantity']) {
            return back()->with('error', "Insufficient stock. Available: {$item->quantity} {$item->unit}");
        }

        $validated['issued_by'] = auth()->id();
        ItemIssue::create($validated);
        $item->decrement('quantity', $validated['quantity']);
        return back()->with('success', 'Item issued.');
    }

    // Suppliers
    public function suppliersIndex()
    {
        $suppliers = Supplier::withCount('stocks')->orderBy('name')->paginate(20);
        return view('inventory.suppliers', compact('suppliers'));
    }

    public function storeSupplier(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255|unique:suppliers,name',
            'contact_person' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:30',
            'email'          => 'nullable|email',
            'address'        => 'nullable|string',
        ]);
        Supplier::create($validated);
        return back()->with('success', 'Supplier added.');
    }

    // Stores & Categories
    public function storeStore(Request $request)
    {
        $request->validate(['name'=>'required|string|max:255|unique:stores,name','location'=>'nullable|string']);
        Store::create($request->only('name','location','description'));
        return back()->with('success', 'Store added.');
    }

    public function storeCat(Request $request)
    {
        $request->validate(['name'=>'required|string|max:100|unique:item_categories,name']);
        ItemCategory::create(['name'=>$request->name]);
        return back()->with('success', 'Category added.');
    }
}
