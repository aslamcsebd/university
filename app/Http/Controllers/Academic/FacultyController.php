<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $query = Faculty::withCount(['departments', 'programs'])->latest();
        if ($request->filled('search')) { $query->where('name', 'like', '%'.$request->search.'%'); }
        $faculties = $query->paginate(20)->withQueryString();
        return view('academic.faculties.index', compact('faculties'));
    }

    public function create() { return view('academic.faculties.create'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:faculties,name',
            'short_name'  => 'required|string|max:10|unique:faculties,short_name',
            'code'        => 'nullable|string|max:20|unique:faculties,code',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        if (empty($validated['code']) && $validated['short_name']) {
            $validated['code'] = strtoupper($validated['short_name']);
        }
        Faculty::create($validated);
        return redirect()->route('faculties.index')->with('success', 'Faculty created successfully.');
    }

    public function edit(Faculty $faculty)
    {
        return view('academic.faculties.edit', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:faculties,name,'.$faculty->id,
            'short_name'  => 'required|string|max:10|unique:faculties,short_name,'.$faculty->id,
            'code'        => 'nullable|string|max:20|unique:faculties,code,'.$faculty->id,
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        $faculty->update($validated);
        return redirect()->route('faculties.index')->with('success', 'Faculty updated successfully.');
    }

    public function destroy(Faculty $faculty)
    {
        if ($faculty->departments()->count() > 0) {
            return back()->with('error', 'Cannot delete faculty with departments.');
        }
        $faculty->delete();
        return redirect()->route('faculties.index')->with('success', 'Faculty deleted.');
    }
}
