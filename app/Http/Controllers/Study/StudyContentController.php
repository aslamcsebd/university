<?php

namespace App\Http\Controllers\Study;

use App\Http\Controllers\Controller;
use App\Models\StudyContent;
use App\Models\ContentType;
use App\Models\SessionCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudyContentController extends Controller
{
    public function index(Request $request)
    {
        $contents = StudyContent::with(['contentType', 'sessionCourse', 'uploader'])
            ->when($request->type, fn($q) => $q->where('content_type_id', $request->type))
            ->latest()->paginate(20)->withQueryString();
        $types   = ContentType::orderBy('name')->get();
        $courses = SessionCourse::with(['course', 'semester'])->latest()->get();
        return view('study.content-list', compact('contents', 'types', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'session_course_id' => 'nullable|exists:session_courses,id',
            'content_type_id'   => 'required|exists:content_types,id',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'file'              => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,mp4|max:51200',
            'is_published'      => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            $path            = $request->file('file')->store('study-materials', 'public');
            $data['file_path'] = $path;
            $data['file_size'] = $request->file('file')->getSize();
        }

        $data['uploaded_by'] = auth()->id();
        unset($data['file']);
        StudyContent::create($data);
        return back()->with('success', 'Content uploaded.');
    }

    public function destroy(StudyContent $content)
    {
        if ($content->file_path) {
            Storage::disk('public')->delete($content->file_path);
        }
        $content->delete();
        return back()->with('success', 'Content deleted.');
    }

    public function downloadsIndex(Request $request)
    {
        $contents = StudyContent::with(['contentType', 'sessionCourse'])
            ->where('is_published', true)
            ->latest()->paginate(20)->withQueryString();
        return view('study.downloads', compact('contents'));
    }
}
