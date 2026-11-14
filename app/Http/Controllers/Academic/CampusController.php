<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\University;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index(Request $request)
    {
        $query = Campus::withCount('buildings')->latest();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        $campuses = $query->paginate(20)->withQueryString();
        return view('academic.campuses.index', compact('campuses'));
    }

    public function create()
    {
        return view('academic.campuses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:campuses,name',
            'address'   => 'nullable|string',
            'phone'     => 'nullable|string|max:30',
            'is_active' => 'boolean',
        ]);
        $validated['university_id'] = University::current()?->id;
        $validated['is_active'] = $request->boolean('is_active', true);
        Campus::create($validated);
        return redirect()->route('campuses.index')->with('success', 'Campus created successfully.');
    }

    public function edit(Campus $campus)
    {
        return view('academic.campuses.edit', compact('campus'));
    }

    public function update(Request $request, Campus $campus)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:campuses,name,'.$campus->id,
            'address'   => 'nullable|string',
            'phone'     => 'nullable|string|max:30',
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        $campus->update($validated);
        return redirect()->route('campuses.index')->with('success', 'Campus updated successfully.');
    }

    public function destroy(Campus $campus)
    {
        if ($campus->buildings()->count() > 0) {
            return back()->with('error', 'Cannot delete campus with buildings. Remove buildings first.');
        }
        $campus->delete();
        return redirect()->route('campuses.index')->with('success', 'Campus deleted successfully.');
    }
}
