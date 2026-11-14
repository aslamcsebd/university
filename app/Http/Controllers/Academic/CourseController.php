<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\Subject;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('department')->withCount('subjects')->latest();
        if ($request->filled('search'))     { $query->where(function($q) use ($request) { $q->where('name', 'like', '%'.$request->search.'%')->orWhere('code', 'like', '%'.$request->search.'%'); }); }
        if ($request->filled('department')) { $query->where('department_id', $request->department); }
        if ($request->filled('type'))       { $query->where('type', $request->type); }
        $courses     = $query->paginate(20)->withQueryString();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $types       = ['core', 'elective', 'lab', 'thesis', 'other'];
        return view('academic.courses.index', compact('courses', 'departments', 'types'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $types       = ['core', 'elective', 'lab', 'thesis', 'other'];
        return view('academic.courses.create', compact('departments', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:50|unique:courses,code',
            'credit_hours'  => 'required|numeric|min:0.5|max:6',
            'type'          => 'required|in:core,elective,lab,thesis,other',
            'description'   => 'nullable|string',
            'is_active'     => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        Course::create($validated);
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load(['department', 'subjects', 'prerequisites']);
        return view('academic.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $types       = ['core', 'elective', 'lab', 'thesis', 'other'];
        return view('academic.courses.edit', compact('course', 'departments', 'types'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:50|unique:courses,code,'.$course->id,
            'credit_hours'  => 'required|numeric|min:0.5|max:6',
            'type'          => 'required|in:core,elective,lab,thesis,other',
            'description'   => 'nullable|string',
            'is_active'     => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        $course->update($validated);
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted.');
    }

    // Subject management
    public function storeSubject(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
        ]);
        $validated['course_id'] = $course->id;
        Subject::create($validated);
        return back()->with('success', 'Subject added.');
    }

    public function destroySubject(Course $course, Subject $subject)
    {
        $subject->delete();
        return back()->with('success', 'Subject removed.');
    }
}
