<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\SessionCourse;
use App\Models\Semester;
use App\Models\Room;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $semester  = $request->filled('semester_id')
            ? Semester::find($request->semester_id)
            : Semester::where('is_current', true)->first();

        $schedules = ClassSchedule::with(['sessionCourse.course', 'sessionCourse.section.batch', 'room'])
            ->whereHas('sessionCourse', fn($q) => $semester ? $q->where('semester_id', $semester->id) : $q)
            ->where('is_active', true)
            ->orderBy('day_of_week')->orderBy('start_time')
            ->get();

        $semesters = Semester::with('academicSession')->orderByDesc('created_at')->get();
        $days      = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

        return view('schedules.index', compact('schedules', 'semesters', 'semester', 'days'));
    }

    public function create()
    {
        $sessionCourses = SessionCourse::with(['course', 'section.batch', 'semester'])
            ->whereHas('semester', fn($q) => $q->where('is_current', true))
            ->get();
        $rooms = Room::where('is_active', true)->with('building')->orderBy('name')->get();
        $days  = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        return view('schedules.create', compact('sessionCourses', 'rooms', 'days'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_course_id' => 'required|exists:session_courses,id',
            'day_of_week'       => 'required|integer|between:0,6',
            'start_time'        => 'required|date_format:H:i',
            'end_time'          => 'required|date_format:H:i|after:start_time',
            'room_id'           => 'nullable|exists:rooms,id',
        ]);

        $schedule = new ClassSchedule($validated);
        $schedule->sessionCourse; // load relation
        $conflicts = $schedule->hasConflict();

        if (!empty($conflicts)) {
            return back()->withErrors(['conflict' => implode(', ', $conflicts)])->withInput();
        }

        ClassSchedule::create($validated);
        return redirect()->route('schedules.index')->with('success', 'Class schedule created.');
    }

    public function destroy(ClassSchedule $schedule)
    {
        $schedule->update(['is_active' => false]);
        return back()->with('success', 'Schedule removed.');
    }
}
