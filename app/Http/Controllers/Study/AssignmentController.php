<?php

namespace App\Http\Controllers\Study;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\SessionCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $assignments = Assignment::with(['sessionCourse.course', 'creator'])
            ->when($request->course, fn($q) => $q->where('session_course_id', $request->course))
            ->latest()->paginate(20)->withQueryString();
        $courses = SessionCourse::with('course')->latest()->get();
        return view('study.assignments', compact('assignments', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'session_course_id' => 'nullable|exists:session_courses,id',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'due_date'          => 'required|date|after:now',
            'max_marks'         => 'nullable|numeric|min:0',
            'attachment'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:51200',
            'is_published'      => 'boolean',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('assignments', 'public');
        }

        $data['created_by'] = auth()->id();
        unset($data['attachment']);
        Assignment::create($data);
        return back()->with('success', 'Assignment created.');
    }

    public function update(Request $request, Assignment $assignment)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'due_date'     => 'required|date',
            'max_marks'    => 'nullable|numeric|min:0',
            'is_published' => 'boolean',
        ]);
        $assignment->update($data);
        return back()->with('success', 'Assignment updated.');
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->attachment_path) {
            Storage::disk('public')->delete($assignment->attachment_path);
        }
        $assignment->delete();
        return back()->with('success', 'Assignment deleted.');
    }
}
