<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use App\Models\SessionCourse;
use App\Models\Semester;
use App\Models\Room;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    public function index(Request $request)
    {
        $semester  = $request->filled('semester_id')
            ? Semester::find($request->semester_id)
            : Semester::where('is_current', true)->first();

        $schedules = ExamSchedule::with(['sessionCourse.course', 'sessionCourse.section', 'room'])
            ->whereHas('sessionCourse', fn($q) => $semester ? $q->where('semester_id', $semester->id) : $q)
            ->orderBy('date')->orderBy('start_time')
            ->get();

        $semesters = Semester::with('academicSession')->orderByDesc('created_at')->get();
        return view('schedules.exams', compact('schedules', 'semesters', 'semester'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_course_id' => 'required|exists:session_courses,id',
            'room_id'           => 'nullable|exists:rooms,id',
            'date'              => 'required|date|after_or_equal:today',
            'start_time'        => 'required|date_format:H:i',
            'end_time'          => 'required|date_format:H:i|after:start_time',
        ]);
        ExamSchedule::create($validated);
        return back()->with('success', 'Exam schedule created.');
    }

    public function publish(ExamSchedule $examSchedule)
    {
        $examSchedule->update(['is_published' => true]);
        return back()->with('success', 'Exam schedule published.');
    }

    public function destroy(ExamSchedule $examSchedule)
    {
        $examSchedule->delete();
        return back()->with('success', 'Exam schedule deleted.');
    }
}
