<?php

namespace App\Http\Controllers\Study;

use App\Http\Controllers\Controller;
use App\Models\StudyContent;
use App\Models\Assignment;
use App\Models\ContentType;
use App\Models\SessionCourse;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function index(Request $request)
    {
        $contents    = StudyContent::with(['sessionCourse.course','contentType'])->latest()->paginate(20);
        $assignments = Assignment::with(['sessionCourse.course'])->latest()->paginate(10);
        $types       = ContentType::orderBy('name')->get();
        $courses     = SessionCourse::with('course')->whereHas('semester', fn($q) => $q->where('is_current',true))->get();
        return view('study.index', compact('contents','assignments','types','courses'));
    }

    public function storeContent(Request $request)
    {
        $validated = $request->validate([
            'session_course_id' => 'required|exists:session_courses,id',
            'content_type_id'   => 'nullable|exists:content_types,id',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'file'              => 'nullable|file|max:51200|mimes:pdf,doc,docx,ppt,pptx,zip,mp4',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_path'] = $file->store('study-materials', 'public');
            $validated['file_size'] = round($file->getSize() / 1024, 1) . ' KB';
        }

        $validated['uploaded_by'] = auth()->id();
        StudyContent::create($validated);
        return back()->with('success', 'Material uploaded.');
    }

    public function destroyContent(StudyContent $content)
    {
        $content->delete();
        return back()->with('success', 'Material removed.');
    }

    public function storeAssignment(Request $request)
    {
        $validated = $request->validate([
            'session_course_id' => 'required|exists:session_courses,id',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'due_date'          => 'required|date|after:today',
            'max_marks'         => 'nullable|numeric|min:0',
        ]);
        $validated['created_by'] = auth()->id();
        Assignment::create($validated);
        return back()->with('success', 'Assignment created.');
    }

    public function destroyAssignment(Assignment $assignment)
    {
        $assignment->delete();
        return back()->with('success', 'Assignment deleted.');
    }

    public function storeType(Request $request)
    {
        $request->validate(['name'=>'required|string|max:100|unique:content_types,name']);
        ContentType::create(['name'=>$request->name]);
        return back()->with('success', 'Content type added.');
    }
}
