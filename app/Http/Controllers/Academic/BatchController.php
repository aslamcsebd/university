<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Program;
use App\Models\AcademicSession;
use App\Models\Section;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index(Request $request)
    {
        $query = Batch::with(['program.department', 'academicSession'])->withCount('sections')->latest();
        if ($request->filled('search'))  { $query->where('name', 'like', '%'.$request->search.'%'); }
        if ($request->filled('program')) { $query->where('program_id', $request->program); }
        $batches  = $query->paginate(20)->withQueryString();
        $programs = Program::with('department')->where('is_active', true)->orderBy('name')->get();
        return view('academic.batches.index', compact('batches', 'programs'));
    }

    public function create()
    {
        $programs  = Program::with('department')->where('is_active', true)->orderBy('name')->get();
        $sessions  = AcademicSession::orderBy('name')->get();
        return view('academic.batches.create', compact('programs', 'sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id'          => 'required|exists:programs,id',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'name'                => 'required|string|max:100',
            'intake_year'         => 'nullable|integer|min:2000|max:2100',
            'max_students'        => 'nullable|integer|min:0',
            'is_active'           => 'boolean',
        ]);
        $validated['is_active']    = $request->boolean('is_active', true);
        $validated['max_students'] = $validated['max_students'] ?? 0;
        Batch::create($validated);
        return redirect()->route('batches.index')->with('success', 'Batch created successfully.');
    }

    public function edit(Batch $batch)
    {
        $batch->load('sections');
        $programs = Program::with('department')->where('is_active', true)->orderBy('name')->get();
        $sessions = AcademicSession::orderBy('name')->get();
        return view('academic.batches.edit', compact('batch', 'programs', 'sessions'));
    }

    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'program_id'          => 'required|exists:programs,id',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'name'                => 'required|string|max:100',
            'intake_year'         => 'nullable|integer|min:2000|max:2100',
            'max_students'        => 'nullable|integer|min:0',
            'is_active'           => 'boolean',
        ]);
        $validated['is_active']    = $request->boolean('is_active', true);
        $validated['max_students'] = $validated['max_students'] ?? 0;
        $batch->update($validated);
        return redirect()->route('batches.index')->with('success', 'Batch updated.');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->route('batches.index')->with('success', 'Batch deleted.');
    }

    // Section management within batch
    public function storeSection(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:50',
            'capacity' => 'nullable|integer|min:1',
        ]);
        $validated['batch_id'] = $batch->id;
        Section::create($validated);
        return back()->with('success', 'Section added.');
    }

    public function destroySection(Batch $batch, Section $section)
    {
        $section->delete();
        return back()->with('success', 'Section removed.');
    }
}
