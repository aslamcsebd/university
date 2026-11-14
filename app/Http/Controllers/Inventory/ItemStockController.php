<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemStock;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ItemStockController extends Controller
{
    public function index(Request $request)
    {
        $stocks    = ItemStock::with(['item', 'supplier', 'receiver'])
            ->when($request->item, fn($q) => $q->where('item_id', $request->item))
            ->latest()->paginate(20)->withQueryString();
        $items     = Item::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('inventory.item-stocks', compact('stocks', 'items', 'suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id'       => 'required|exists:items,id',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'quantity'      => 'required|numeric|min:0.01',
            'unit_cost'     => 'nullable|numeric|min:0',
            'purchase_date' => 'required|date',
            'invoice_no'    => 'nullable|string|max:100',
        ]);
        $data['total_cost']  = ($data['quantity'] * ($data['unit_cost'] ?? 0));
        $data['received_by'] = auth()->id();

        ItemStock::create($data);
        Item::findOrFail($data['item_id'])->increment('quantity', $data['quantity']);
        return back()->with('success', 'Stock added.');
    }
}
