<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Staff;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores   = Store::with('incharge')->withCount('items')->latest()->get();
        $staffList = Staff::where('is_active', true)->orderBy('first_name')->get();
        return view('inventory.stores', compact('stores', 'staffList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'location'    => 'nullable|string|max:200',
            'incharge_id' => 'nullable|exists:staff,id',
            'description' => 'nullable|string',
        ]);
        Store::create($data);
        return back()->with('success', 'Store added.');
    }

    public function update(Request $request, Store $store)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'location'    => 'nullable|string|max:200',
            'incharge_id' => 'nullable|exists:staff,id',
            'description' => 'nullable|string',
        ]);
        $store->update($data);
        return back()->with('success', 'Store updated.');
    }

    public function destroy(Store $store)
    {
        if ($store->items()->exists()) {
            return back()->with('error', 'Cannot delete store with items.');
        }
        $store->delete();
        return back()->with('success', 'Store deleted.');
    }
}
