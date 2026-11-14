<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\AdmissionStatus;
use App\Models\AdmissionStatusHistory;
use App\Models\AcademicSession;
use App\Models\Program;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = AdmissionApplication::with(['program', 'status', 'academicSession'])->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('applicant_name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('status'))  { $query->where('status_id', $request->status); }
        if ($request->filled('program')) { $query->where('program_id', $request->program); }
        if ($request->filled('session')) { $query->where('academic_session_id', $request->session); }

        $applications = $query->paginate(20)->withQueryString();
        $statuses     = AdmissionStatus::orderBy('order')->get();
        $programs     = Program::where('is_active', true)->orderBy('name')->get();
        $sessions     = AcademicSession::orderByDesc('created_at')->get();

        return view('admission.index', compact('applications', 'statuses', 'programs', 'sessions'));
    }

    public function create()
    {
        $programs = Program::where('is_active', true)->with('department')->orderBy('name')->get();
        $sessions = AcademicSession::orderByDesc('created_at')->get();
        return view('admission.create', compact('programs', 'sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id'          => 'required|exists:programs,id',
            'academic_session_id' => 'nullable|exists:academic_sessions,id',
            'applicant_name'      => 'required|string|max:255',
            'email'               => 'required|email',
            'phone'               => 'nullable|string|max:30',
            'dob'                 => 'nullable|date',
            'address'             => 'nullable|string',
            'remarks'             => 'nullable|string',
        ]);

        $defaultStatus = AdmissionStatus::orderBy('order')->first();
        $validated['status_id'] = $defaultStatus?->id;

        $application = AdmissionApplication::create($validated);

        // Record history
        AdmissionStatusHistory::create([
            'application_id' => $application->id,
            'status_id'      => $defaultStatus?->id,
            'changed_by'     => auth()->id(),
            'note'           => 'Application submitted',
            'created_at'     => now(),
        ]);

        return redirect()->route('admissions.show', $application)
            ->with('success', 'Application created successfully.');
    }

    public function show(AdmissionApplication $admission)
    {
        $admission->load(['program.department', 'status', 'academicSession', 'statusHistory.status', 'statusHistory.changedBy']);
        $statuses = AdmissionStatus::orderBy('order')->get();
        return view('admission.show', compact('admission', 'statuses'));
    }

    public function updateStatus(Request $request, AdmissionApplication $admission)
    {
        $request->validate([
            'status_id' => 'required|exists:admission_statuses,id',
            'note'      => 'nullable|string',
        ]);

        $admission->update([
            'status_id'   => $request->status_id,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'remarks'     => $request->note,
        ]);

        AdmissionStatusHistory::create([
            'application_id' => $admission->id,
            'status_id'      => $request->status_id,
            'changed_by'     => auth()->id(),
            'note'           => $request->note,
            'created_at'     => now(),
        ]);

        return back()->with('success', 'Status updated.');
    }

    public function convert(AdmissionApplication $admission)
    {
        if (!$admission->status?->is_approval_trigger) {
            return back()->with('error', 'Application must be in an approved status to convert.');
        }

        $student = $admission->convertToStudent();

        return redirect()->route('students.show', $student)
            ->with('success', 'Application converted to student successfully. Student ID: '.$student->student_id);
    }

    public function destroy(AdmissionApplication $admission)
    {
        $admission->delete();
        return redirect()->route('admissions.index')->with('success', 'Application deleted.');
    }
}
