<?php

namespace App\Http\Controllers\Examination;

use App\Http\Controllers\Controller;
use App\Models\StudentResult;
use App\Models\StudentSemesterSummary;
use App\Models\StudentMark;
use App\Models\MarkDistribution;
use App\Models\StudentEnrollment;
use App\Models\Semester;
use App\Models\GradingSystem;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $semester  = $request->filled('semester_id')
            ? Semester::find($request->semester_id)
            : Semester::where('is_current', true)->first();

        $results   = StudentResult::with(['student', 'sessionCourse.course'])
            ->where('semester_id', $semester?->id)
            ->orderBy('is_published')
            ->paginate(30)->withQueryString();

        $semesters = Semester::with('academicSession')->orderByDesc('created_at')->get();

        return view('results.index', compact('results', 'semesters', 'semester'));
    }

    public function process(Request $request)
    {
        $request->validate(['semester_id' => 'required|exists:semesters,id']);

        $semester       = Semester::findOrFail($request->semester_id);
        $gradingSystem  = GradingSystem::getDefault();

        if (!$gradingSystem) {
            return back()->with('error', 'No grading system defined. Please create one first.');
        }

        $enrollments = StudentEnrollment::where('semester_id', $semester->id)
            ->where('status', 'active')->get();

        $processed = 0;

        foreach ($enrollments as $enrollment) {
            $sessionCourses = $semester->sessionCourses()->get();

            foreach ($sessionCourses as $sc) {
                $distributions = MarkDistribution::where('session_course_id', $sc->id)->get();
                if ($distributions->isEmpty()) continue;

                $totalWeightedMarks = 0;
                $totalWeightage     = $distributions->sum('weightage');

                foreach ($distributions as $dist) {
                    $mark = StudentMark::where('student_id', $enrollment->student_id)
                        ->where('mark_distribution_id', $dist->id)->first();
                    if ($mark) {
                        $totalWeightedMarks += ($mark->marks_obtained / $dist->total_marks) * $dist->weightage;
                    }
                }

                $percentage  = $totalWeightage > 0 ? ($totalWeightedMarks / $totalWeightage) * 100 : 0;
                $gradeRule   = $gradingSystem->getGradeForPercentage($percentage);

                StudentResult::updateOrCreate(
                    ['student_id' => $enrollment->student_id, 'session_course_id' => $sc->id],
                    [
                        'semester_id'     => $semester->id,
                        'total_marks'     => $distributions->sum('total_marks'),
                        'obtained_marks'  => round($totalWeightedMarks, 2),
                        'percentage'      => round($percentage, 2),
                        'letter_grade'    => $gradeRule?->letter_grade,
                        'grade_rule_id'   => $gradeRule?->id,
                        'gpa_point'       => $gradeRule?->gpa_point ?? 0,
                        'credit_hours'    => $sc->course->credit_hours,
                        'is_pass'         => $gradeRule?->is_pass ?? false,
                    ]
                );
                $processed++;
            }
        }

        // Calculate GPA summaries
        $this->calculateSemesterGPA($semester);

        return back()->with('success', "Processed {$processed} results for {$semester->name}.");
    }

    public function publish(Request $request)
    {
        $request->validate(['semester_id' => 'required|exists:semesters,id']);

        StudentResult::where('semester_id', $request->semester_id)->update([
            'is_published' => true,
            'published_at' => now(),
            'published_by' => auth()->id(),
        ]);

        StudentSemesterSummary::where('semester_id', $request->semester_id)->update(['is_published' => true]);

        return back()->with('success', 'Results published successfully.');
    }

    private function calculateSemesterGPA(Semester $semester): void
    {
        $students = StudentResult::where('semester_id', $semester->id)
            ->select('student_id')->distinct()->pluck('student_id');

        foreach ($students as $studentId) {
            $results = StudentResult::where('student_id', $studentId)
                ->where('semester_id', $semester->id)->get();

            $totalCredits  = $results->sum('credit_hours');
            $weightedGPA   = $results->sum(fn($r) => $r->gpa_point * $r->credit_hours);
            $semesterGPA   = $totalCredits > 0 ? round($weightedGPA / $totalCredits, 2) : 0;
            $earnedCredits = $results->where('is_pass', true)->sum('credit_hours');

            // CGPA: average across all published semesters
            $allSummaries = StudentSemesterSummary::where('student_id', $studentId)
                ->where('is_published', true)->get();
            $allCredits   = $allSummaries->sum('total_credits_attempted') + $totalCredits;
            $allWeighted  = $allSummaries->sum(fn($s) => $s->semester_gpa * $s->total_credits_attempted) + $weightedGPA;
            $cgpa         = $allCredits > 0 ? round($allWeighted / $allCredits, 2) : $semesterGPA;

            StudentSemesterSummary::updateOrCreate(
                ['student_id' => $studentId, 'semester_id' => $semester->id],
                [
                    'semester_gpa'            => $semesterGPA,
                    'cgpa'                    => $cgpa,
                    'total_credits_attempted' => $totalCredits,
                    'total_credits_earned'    => $earnedCredits,
                ]
            );
        }
    }

    // Mark Ledger
    public function markLedger(Request $request)
    {
        $semester = $request->filled('semester_id')
            ? Semester::find($request->semester_id)
            : Semester::where('is_current', true)->first();

        $results = StudentResult::with(['student', 'sessionCourse.course', 'gradeRule'])
            ->where('semester_id', $semester?->id)
            ->orderBy('student_id')
            ->paginate(50)->withQueryString();

        $semesters = Semester::with('academicSession')->orderByDesc('created_at')->get();

        return view('examinations.exam-mark-ledger', compact('results', 'semesters', 'semester'));
    }
}
