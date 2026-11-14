<?php

namespace App\Http\Controllers\Examination;

use App\Http\Controllers\Controller;
use App\Models\ExamType;
use App\Models\MarkDistribution;
use App\Models\StudentMark;
use App\Models\SessionCourse;
use App\Models\Semester;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    // Exam Types
    public function typesIndex()
    {
        $semester  = Semester::where('is_current', true)->first();
        $examTypes = ExamType::with('semester')->where('semester_id', $semester?->id)
            ->orWhereNull('semester_id')->orderBy('name')->get();
        $semesters = Semester::orderByDesc('created_at')->get();
        return view('examinations.types', compact('examTypes', 'semesters', 'semester'));
    }

    public function storeType(Request $request)
    {
        $validated = $request->validate([
            'semester_id'  => 'nullable|exists:semesters,id',
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
        ]);
        ExamType::create($validated);
        return back()->with('success', 'Exam type added.');
    }

    public function destroyType(ExamType $examType)
    {
        if ($examType->markDistributions()->count()) {
            return back()->with('error', 'Cannot delete exam type with mark distributions.');
        }
        $examType->delete();
        return back()->with('success', 'Exam type deleted.');
    }

    // Mark Distributions
    public function distributionsIndex(Request $request)
    {
        $semester       = Semester::where('is_current', true)->first();
        $sessionCourses = SessionCourse::with(['course', 'section'])
            ->whereHas('semester', fn($q) => $q->where('is_current', true))->get();
        $distributions  = MarkDistribution::with(['sessionCourse.course', 'examType'])
            ->whereHas('sessionCourse.semester', fn($q) => $q->where('is_current', true))->get();
        $examTypes      = ExamType::orderBy('name')->get();

        return view('examinations.distributions', compact('distributions', 'sessionCourses', 'examTypes', 'semester'));
    }

    public function storeDistribution(Request $request)
    {
        $validated = $request->validate([
            'session_course_id' => 'required|exists:session_courses,id',
            'exam_type_id'      => 'required|exists:exam_types,id',
            'total_marks'       => 'required|numeric|min:1',
            'pass_marks'        => 'nullable|numeric|min:0|lte:total_marks',
            'weightage'         => 'required|numeric|min:0.01|max:100',
        ]);
        MarkDistribution::updateOrCreate(
            ['session_course_id' => $validated['session_course_id'], 'exam_type_id' => $validated['exam_type_id']],
            $validated
        );
        return back()->with('success', 'Mark distribution saved.');
    }

    public function destroyDistribution(MarkDistribution $distribution)
    {
        $distribution->delete();
        return back()->with('success', 'Distribution deleted.');
    }

    // Mark Entry
    public function marksIndex(Request $request)
    {
        $semester       = Semester::where('is_current', true)->first();
        $sessionCourses = SessionCourse::with(['course', 'section'])
            ->whereHas('semester', fn($q) => $q->where('is_current', true))->get();

        $selectedCourse = $request->filled('session_course_id')
            ? SessionCourse::with(['course', 'section'])->find($request->session_course_id)
            : null;

        $selectedDistribution = $request->filled('distribution_id')
            ? MarkDistribution::with('examType')->find($request->distribution_id)
            : null;

        $students = [];
        if ($selectedDistribution) {
            $enrolled = StudentEnrollment::where('semester_id', $selectedCourse->semester_id)
                ->where('status', 'active')->with('student')->get();

            $existingMarks = StudentMark::where('mark_distribution_id', $selectedDistribution->id)
                ->pluck('marks_obtained', 'student_id');
            $absentStudents = StudentMark::where('mark_distribution_id', $selectedDistribution->id)
                ->where('is_absent', true)->pluck('is_absent', 'student_id');

            $students = $enrolled->map(fn($e) => [
                'id'       => $e->student->id,
                'name'     => $e->student->full_name,
                'sid'      => $e->student->student_id,
                'marks'    => $existingMarks[$e->student->id] ?? '',
                'is_absent'=> $absentStudents[$e->student->id] ?? false,
            ]);
        }

        $distributions = $selectedCourse
            ? MarkDistribution::with('examType')->where('session_course_id', $selectedCourse->id)->get()
            : collect();

        return view('examinations.marks', compact('sessionCourses', 'selectedCourse', 'selectedDistribution', 'distributions', 'students', 'semester'));
    }

    public function saveMarks(Request $request)
    {
        $request->validate([
            'distribution_id' => 'required|exists:mark_distributions,id',
            'marks'           => 'required|array',
        ]);

        $distribution = MarkDistribution::findOrFail($request->distribution_id);

        foreach ($request->marks as $studentId => $data) {
            $isAbsent = isset($data['is_absent']) && $data['is_absent'];
            $marks    = $isAbsent ? 0 : ($data['marks'] ?? 0);

            if ($marks > $distribution->total_marks) {
                return back()->with('error', "Marks cannot exceed {$distribution->total_marks} for a student.")->withInput();
            }

            StudentMark::updateOrCreate(
                ['student_id' => $studentId, 'mark_distribution_id' => $request->distribution_id],
                ['marks_obtained' => $marks, 'is_absent' => $isAbsent, 'entered_by' => auth()->id()]
            );
        }

        return back()->with('success', 'Marks saved successfully.');
    }
}
