<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::with(['department.faculty'])->withCount('batches')->latest();
        if ($request->filled('search'))     { $query->where('name', 'like', '%'.$request->search.'%'); }
        if ($request->filled('department')) { $query->where('department_id', $request->department); }
        if ($request->filled('level'))      { $query->where('level', $request->level); }
        $programs    = $query->paginate(20)->withQueryString();
        $departments = Department::with('faculty')->where('type', 'academic')->where('is_active', true)->orderBy('name')->get();
        $levels      = ['certificate', 'diploma', 'bachelor', 'master', 'phd', 'other'];
        return view('academic.programs.index', compact('programs', 'departments', 'levels'));
    }

    public function create()
    {
        $departments = Department::with('faculty')->where('type', 'academic')->where('is_active', true)->orderBy('name')->get();
        $levels      = ['certificate', 'diploma', 'bachelor', 'master', 'phd', 'other'];
        return view('academic.programs.create', compact('departments', 'levels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id'  => 'required|exists:departments,id',
            'name'           => 'required|string|max:255',
            'short_name'     => 'required|string|max:20|unique:programs,short_name',
            'code'           => 'nullable|string|max:20|unique:programs,code',
            'level'          => 'required|in:certificate,diploma,bachelor,master,phd,other',
            'duration_years' => 'required|numeric|min:0.5|max:10',
            'total_credits'  => 'nullable|integer|min:0',
            'description'    => 'nullable|string',
            'is_active'      => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        Program::create($validated);
        return redirect()->route('programs.index')->with('success', 'Program created successfully.');
    }

    public function edit(Program $program)
    {
        $departments = Department::with('faculty')->where('type', 'academic')->where('is_active', true)->orderBy('name')->get();
        $levels      = ['certificate', 'diploma', 'bachelor', 'master', 'phd', 'other'];
        return view('academic.programs.edit', compact('program', 'departments', 'levels'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'department_id'  => 'required|exists:departments,id',
            'name'           => 'required|string|max:255',
            'short_name'     => 'required|string|max:20|unique:programs,short_name,'.$program->id,
            'code'           => 'nullable|string|max:20|unique:programs,code,'.$program->id,
            'level'          => 'required|in:certificate,diploma,bachelor,master,phd,other',
            'duration_years' => 'required|numeric|min:0.5|max:10',
            'total_credits'  => 'nullable|integer|min:0',
            'description'    => 'nullable|string',
            'is_active'      => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        $program->update($validated);
        return redirect()->route('programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        if ($program->batches()->count() > 0) {
            return back()->with('error', 'Cannot delete program with batches.');
        }
        $program->delete();
        return redirect()->route('programs.index')->with('success', 'Program deleted.');
    }
}
