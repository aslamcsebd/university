<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Campus;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $query = Building::with('campus')->withCount('rooms')->latest();
        if ($request->filled('search'))  { $query->where('name', 'like', '%'.$request->search.'%'); }
        if ($request->filled('campus'))  { $query->where('campus_id', $request->campus); }
        $buildings = $query->paginate(20)->withQueryString();
        $campuses  = Campus::where('is_active', true)->orderBy('name')->get();
        return view('academic.buildings.index', compact('buildings', 'campuses'));
    }

    public function create()
    {
        $campuses = Campus::where('is_active', true)->orderBy('name')->get();
        return view('academic.buildings.create', compact('campuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'campus_id'   => 'required|exists:campuses,id',
            'name'        => 'required|string|max:255',
            'floors'      => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        Building::create($validated);
        return redirect()->route('buildings.index')->with('success', 'Building created successfully.');
    }

    public function edit(Building $building)
    {
        $campuses = Campus::where('is_active', true)->orderBy('name')->get();
        return view('academic.buildings.edit', compact('building', 'campuses'));
    }

    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'campus_id'   => 'required|exists:campuses,id',
            'name'        => 'required|string|max:255',
            'floors'      => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        $building->update($validated);
        return redirect()->route('buildings.index')->with('success', 'Building updated successfully.');
    }

    public function destroy(Building $building)
    {
        if ($building->rooms()->count() > 0) {
            return back()->with('error', 'Cannot delete building with rooms. Remove rooms first.');
        }
        $building->delete();
        return redirect()->route('buildings.index')->with('success', 'Building deleted.');
    }
}
