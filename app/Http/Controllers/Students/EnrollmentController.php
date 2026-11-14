<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentEnrollment;
use App\Models\StudentCourseEnrollment;
use App\Models\Semester;
use App\Models\Section;
use App\Models\Batch;
use App\Models\SessionCourse;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentEnrollment::with(['student.program', 'semester', 'section.batch'])->latest();

        if ($request->filled('semester')) { $query->where('semester_id', $request->semester); }
        if ($request->filled('status'))   { $query->where('status', $request->status); }

        $enrollments = $query->paginate(20)->withQueryString();
        $semesters   = Semester::with('academicSession')->orderByDesc('created_at')->get();

        return view('students.enrollments', compact('enrollments', 'semesters'));
    }

    public function create()
    {
        $students  = Student::active()->with('program')->orderBy('first_name')->get();
        $semesters = Semester::with('academicSession')->orderByDesc('created_at')->get();
        $sections  = Section::with('batch.program')->orderBy('name')->get();
        return view('students.enroll', compact('students', 'semesters', 'sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'section_id'  => 'nullable|exists:sections,id',
        ]);

        // Check for duplicate
        if (StudentEnrollment::where('student_id', $validated['student_id'])
                              ->where('semester_id', $validated['semester_id'])
                              ->exists()) {
            return back()->with('error', 'Student is already enrolled in this semester.');
        }

        StudentEnrollment::create([
            'student_id'  => $validated['student_id'],
            'semester_id' => $validated['semester_id'],
            'section_id'  => $validated['section_id'],
            'enrolled_at' => now(),
            'status'      => 'active',
        ]);

        return redirect()->route('enrollments.index')->with('success', 'Student enrolled successfully.');
    }

    public function bulkEnroll(Request $request)
    {
        $validated = $request->validate([
            'batch_id'    => 'required|exists:batches,id',
            'semester_id' => 'required|exists:semesters,id',
            'section_id'  => 'nullable|exists:sections,id',
        ]);

        $students = Student::where('batch_id', $validated['batch_id'])
                           ->where('status', 'active')
                           ->get();

        $enrolled = 0;
        $skipped  = 0;

        foreach ($students as $student) {
            if (StudentEnrollment::where('student_id', $student->id)
                                 ->where('semester_id', $validated['semester_id'])
                                 ->exists()) {
                $skipped++;
                continue;
            }

            StudentEnrollment::create([
                'student_id'  => $student->id,
                'semester_id' => $validated['semester_id'],
                'section_id'  => $validated['section_id'],
                'enrolled_at' => now(),
                'status'      => 'active',
            ]);
            $enrolled++;
        }

        return redirect()->route('enrollments.index')
            ->with('success', "Enrolled {$enrolled} students. Skipped {$skipped} (already enrolled).");
    }

    public function withdraw(StudentEnrollment $enrollment)
    {
        $enrollment->update(['status' => 'withdrawn', 'withdrawn_at' => now()]);
        return back()->with('success', 'Enrollment withdrawn.');
    }
}
