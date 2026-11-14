<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\Semester;
use Illuminate\Http\Request;

class AcademicSessionController extends Controller
{
    public function index()
    {
        $sessions = AcademicSession::withCount('semesters')->latest()->paginate(20);
        return view('academic.sessions.index', compact('sessions'));
    }

    public function create() { return view('academic.sessions.create'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100|unique:academic_sessions,name',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);
        if ($request->boolean('is_current')) {
            AcademicSession::query()->update(['is_current' => false]);
        }
        $validated['is_current'] = $request->boolean('is_current');
        AcademicSession::create($validated);
        return redirect()->route('sessions.index')->with('success', 'Academic session created.');
    }

    public function edit(AcademicSession $session)
    {
        $session->load('semesters');
        return view('academic.sessions.edit', compact('session'));
    }

    public function update(Request $request, AcademicSession $session)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100|unique:academic_sessions,name,'.$session->id,
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);
        if ($request->boolean('is_current')) {
            AcademicSession::where('id', '!=', $session->id)->update(['is_current' => false]);
        }
        $validated['is_current'] = $request->boolean('is_current');
        $session->update($validated);
        return redirect()->route('sessions.index')->with('success', 'Session updated.');
    }

    public function destroy(AcademicSession $session)
    {
        if ($session->semesters()->count() > 0) {
            return back()->with('error', 'Cannot delete session with semesters.');
        }
        $session->delete();
        return redirect()->route('sessions.index')->with('success', 'Session deleted.');
    }

    // Semester CRUD
    public function storeSemester(Request $request, AcademicSession $session)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'term'       => 'required|integer|min:1|max:3',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
        ]);
        if ($request->boolean('is_current')) {
            Semester::where('academic_session_id', $session->id)->update(['is_current' => false]);
        }
        $validated['academic_session_id'] = $session->id;
        $validated['is_current'] = $request->boolean('is_current');
        Semester::create($validated);
        return redirect()->route('sessions.edit', $session)->with('success', 'Semester added.');
    }

    public function destroySemester(AcademicSession $session, Semester $semester)
    {
        $semester->delete();
        return redirect()->route('sessions.edit', $session)->with('success', 'Semester removed.');
    }
}
