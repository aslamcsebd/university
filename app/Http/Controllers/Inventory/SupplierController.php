<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('stocks')->latest()->get();
        return view('inventory.suppliers', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:200',
            'contact_person' => 'nullable|string|max:100',
            'phone'          => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:200',
            'address'        => 'nullable|string',
        ]);
        Supplier::create($data);
        return back()->with('success', 'Supplier added.');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:200',
            'contact_person' => 'nullable|string|max:100',
            'phone'          => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:200',
            'address'        => 'nullable|string',
        ]);
        $supplier->update($data);
        return back()->with('success', 'Supplier updated.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Supplier deleted.');
    }
}
