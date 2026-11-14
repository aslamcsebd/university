<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with('faculty')->withCount('programs')->latest();
        if ($request->filled('search'))  { $query->where('name', 'like', '%'.$request->search.'%'); }
        if ($request->filled('faculty')) { $query->where('faculty_id', $request->faculty); }
        if ($request->filled('type'))    { $query->where('type', $request->type); }
        $departments = $query->paginate(20)->withQueryString();
        $faculties   = Faculty::where('is_active', true)->orderBy('name')->get();
        return view('academic.departments.index', compact('departments', 'faculties'));
    }

    public function create()
    {
        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();
        return view('academic.departments.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'faculty_id'  => 'nullable|exists:faculties,id',
            'name'        => 'required|string|max:255',
            'short_name'  => 'nullable|string|max:50',
            'code'        => 'nullable|string|max:20',
            'type'        => 'required|in:academic,hr,admin',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        Department::create($validated);
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();
        return view('academic.departments.edit', compact('department', 'faculties'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'faculty_id'  => 'nullable|exists:faculties,id',
            'name'        => 'required|string|max:255',
            'short_name'  => 'nullable|string|max:50',
            'code'        => 'nullable|string|max:20',
            'type'        => 'required|in:academic,hr,admin',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        $department->update($validated);
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        if ($department->programs()->count() > 0) {
            return back()->with('error', 'Cannot delete department with programs.');
        }
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted.');
    }
}
