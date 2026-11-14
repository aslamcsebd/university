<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\Student;
use App\Models\Semester;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::withCount('applications')->orderBy('name')->paginate(20);
        return view('finance.scholarships', compact('scholarships'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:100|unique:scholarships,name',
            'type'              => 'required|in:merit,need_based,sports,disability,staff_dependent,other',
            'description'       => 'nullable|string',
            'value_type'        => 'required|in:percentage,fixed',
            'value'             => 'required|numeric|min:0',
            'max_recipients'    => 'nullable|integer|min:0',
            'application_start' => 'nullable|date',
            'application_end'   => 'nullable|date|after_or_equal:application_start',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        Scholarship::create($validated);
        return back()->with('success', 'Scholarship created.');
    }

    public function applicationsIndex(Request $request)
    {
        $query = ScholarshipApplication::with(['scholarship', 'student', 'semester'])->latest();
        if ($request->filled('status'))      { $query->where('status', $request->status); }
        if ($request->filled('scholarship')) { $query->where('scholarship_id', $request->scholarship); }
        $applications = $query->paginate(20)->withQueryString();
        $scholarships = Scholarship::where('is_active', true)->get();
        return view('finance.scholarship-applications', compact('applications', 'scholarships'));
    }

    public function apply(Request $request)
    {
        $validated = $request->validate([
            'scholarship_id' => 'required|exists:scholarships,id',
            'student_id'     => 'required|exists:students,id',
            'semester_id'    => 'nullable|exists:semesters,id',
            'notes'          => 'nullable|string',
        ]);
        ScholarshipApplication::firstOrCreate(
            ['scholarship_id' => $validated['scholarship_id'], 'student_id' => $validated['student_id'], 'semester_id' => $validated['semester_id']],
            $validated
        );
        return back()->with('success', 'Application submitted.');
    }

    public function approve(ScholarshipApplication $application)
    {
        $application->update(['status' => 'approved', 'reviewed_by' => auth()->id(), 'reviewed_at' => now()]);
        return back()->with('success', 'Scholarship approved.');
    }

    public function reject(ScholarshipApplication $application)
    {
        $application->update(['status' => 'rejected', 'reviewed_by' => auth()->id(), 'reviewed_at' => now()]);
        return back()->with('success', 'Scholarship rejected.');
    }

    public function destroy(Scholarship $scholarship)
    {
        if ($scholarship->applications()->count()) {
            return back()->with('error', 'Cannot delete scholarship with applications.');
        }
        $scholarship->delete();
        return back()->with('success', 'Scholarship deleted.');
    }
}
