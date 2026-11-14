<?php

namespace App\Http\Controllers\Examination;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use App\Models\StaffAttendance;
use App\Models\SessionCourse;
use App\Models\StudentEnrollment;
use App\Models\Staff;
use App\Models\Semester;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // Student attendance
    public function studentsIndex(Request $request)
    {
        $semester = Semester::where('is_current', true)->first();
        $sessionCourses = SessionCourse::with(['course', 'section'])
            ->whereHas('semester', fn($q) => $q->where('is_current', true))
            ->get();

        return view('attendance.students', compact('sessionCourses', 'semester'));
    }

    public function markStudents(Request $request)
    {
        $request->validate([
            'session_course_id' => 'required|exists:session_courses,id',
            'date'              => 'required|date|before_or_equal:today',
            'attendance'        => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status'     => 'required|in:present,absent,late,excused',
        ]);

        foreach ($request->attendance as $record) {
            StudentAttendance::updateOrCreate(
                ['student_id' => $record['student_id'], 'session_course_id' => $request->session_course_id, 'date' => $request->date],
                ['status' => $record['status'], 'marked_by' => auth()->id()]
            );
        }

        return back()->with('success', 'Attendance marked for '.count($request->attendance).' students.');
    }

    public function getStudentsForCourse(Request $request)
    {
        $request->validate(['session_course_id' => 'required|exists:session_courses,id', 'date' => 'required|date']);

        $enrolled = StudentEnrollment::where('semester_id', SessionCourse::find($request->session_course_id)->semester_id)
            ->where('status', 'active')->with('student')->get();

        $existing = StudentAttendance::where('session_course_id', $request->session_course_id)
            ->where('date', $request->date)->pluck('status', 'student_id');

        return response()->json($enrolled->map(fn($e) => [
            'student_id'   => $e->student->id,
            'student_name' => $e->student->full_name,
            'student_no'   => $e->student->student_id,
            'status'       => $existing[$e->student->id] ?? 'present',
        ]));
    }

    // Staff attendance
    public function staffIndex(Request $request)
    {
        $date  = $request->get('date', now()->format('Y-m-d'));
        $staff = Staff::with(['designation', 'workShift'])->where('is_active', true)->orderBy('first_name')->get();
        $existing = StaffAttendance::where('date', $date)->pluck('status', 'staff_id');

        return view('attendance.staff', compact('staff', 'date', 'existing'));
    }

    public function markStaff(Request $request)
    {
        $request->validate([
            'date'       => 'required|date|before_or_equal:today',
            'attendance' => 'required|array',
        ]);

        foreach ($request->attendance as $staffId => $data) {
            StaffAttendance::updateOrCreate(
                ['staff_id' => $staffId, 'date' => $request->date],
                [
                    'status'    => $data['status'] ?? 'absent',
                    'check_in'  => $data['check_in'] ?? null,
                    'check_out' => $data['check_out'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Staff attendance saved.');
    }
}
