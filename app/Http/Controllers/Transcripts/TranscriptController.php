<?php

namespace App\Http\Controllers\Transcripts;

use App\Http\Controllers\Controller;
use App\Models\DocumentGeneration;
use App\Models\Student;
use App\Models\Semester;
use App\Models\StudentResult;
use App\Models\StudentSemesterSummary;
use Illuminate\Http\Request;

class TranscriptController extends Controller
{
    public function index()
    {
        $documents = DocumentGeneration::with(['student', 'semester'])->latest('generated_at')->paginate(20);
        $students  = Student::active()->orderBy('first_name')->get();
        $semesters = Semester::with('academicSession')->orderByDesc('created_at')->get();
        return view('transcripts.index', compact('documents', 'students', 'semesters'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'student_id'    => 'required|exists:students,id',
            'document_type' => 'required|in:marksheet,transcript,certificate,completion',
            'semester_id'   => 'nullable|exists:semesters,id',
        ]);

        $student = Student::findOrFail($validated['student_id']);

        // Check if already generated (mark as duplicate)
        $existing = DocumentGeneration::where('student_id', $validated['student_id'])
            ->where('document_type', $validated['document_type'])
            ->where('semester_id', $validated['semester_id'])
            ->first();

        $certNo = 'DOC-' . strtoupper(substr($validated['document_type'], 0, 3)) . '-' . date('Y') . '-' . str_pad(DocumentGeneration::count() + 1, 5, '0', STR_PAD_LEFT);

        DocumentGeneration::create([
            'student_id'    => $validated['student_id'],
            'document_type' => $validated['document_type'],
            'semester_id'   => $validated['semester_id'],
            'certificate_no'=> $certNo,
            'is_duplicate'  => !!$existing,
            'generated_by'  => auth()->id(),
            'generated_at'  => now(),
        ]);

        return back()->with('success', "Document generated. Certificate No: {$certNo}" . ($existing ? ' (DUPLICATE)' : ''));
    }

    public function show(DocumentGeneration $document)
    {
        $document->load(['student.program', 'student.batch', 'semester']);

        // Get results
        $results = StudentResult::where('student_id', $document->student_id)
            ->where('is_published', true)
            ->with(['sessionCourse.course', 'semester'])
            ->when($document->semester_id, fn($q) => $q->where('semester_id', $document->semester_id))
            ->get();

        $summary = StudentSemesterSummary::where('student_id', $document->student_id)
            ->when($document->semester_id, fn($q) => $q->where('semester_id', $document->semester_id))
            ->get();

        return view('transcripts.show', compact('document', 'results', 'summary'));
    }
}
