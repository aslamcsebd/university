<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentNote;
use App\Models\StudentStatusHistory;
use App\Models\Program;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['program', 'batch'])->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%')
                  ->orWhere('student_id', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('program')) { $query->where('program_id', $request->program); }
        if ($request->filled('batch'))   { $query->where('batch_id', $request->batch); }
        if ($request->filled('status'))  { $query->where('status', $request->status); }

        $students = $query->paginate(20)->withQueryString();
        $programs = Program::where('is_active', true)->orderBy('name')->get();
        $batches  = Batch::where('is_active', true)->orderBy('name')->get();
        $statuses = ['active', 'graduated', 'suspended', 'dropped', 'transferred', 'alumni'];

        return view('students.index', compact('students', 'programs', 'batches', 'statuses'));
    }

    public function create()
    {
        $programs = Program::with('department')->where('is_active', true)->orderBy('name')->get();
        $batches  = Batch::with('program')->where('is_active', true)->orderBy('name')->get();
        return view('students.create', compact('programs', 'batches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'gender'          => 'required|in:male,female,other',
            'dob'             => 'nullable|date',
            'blood_group'     => 'nullable|string|max:5',
            'phone'           => 'nullable|string|max:30',
            'email'           => 'nullable|email',
            'address'         => 'nullable|string',
            'program_id'      => 'required|exists:programs,id',
            'batch_id'        => 'required|exists:batches,id',
            'admission_date'  => 'required|date',
            'guardian_name'   => 'nullable|string|max:200',
            'guardian_phone'  => 'nullable|string|max:30',
            'guardian_relation'=> 'nullable|string|max:50',
            'photo'           => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
            'email_account'   => 'nullable|email|unique:users,email',
            'password'        => 'nullable|min:8',
        ]);

        $program = Program::findOrFail($validated['program_id']);

        $userId = null;
        if ($request->filled('email_account')) {
            $user = User::create([
                'name'              => $validated['first_name'].' '.$validated['last_name'],
                'email'             => $validated['email_account'],
                'password'          => Hash::make($request->password ?? 'Password@123'),
                'is_active'         => true,
                'email_verified_at' => now(),
            ]);
            $user->assignRole('student');
            $userId = $user->id;
        }

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        $validated['user_id']    = $userId;
        $validated['student_id'] = Student::generateStudentId($program);
        $validated['status']     = 'active';
        unset($validated['email_account'], $validated['password']);

        $student = Student::create($validated);

        StudentStatusHistory::create([
            'student_id'  => $student->id,
            'old_status'  => null,
            'new_status'  => 'active',
            'reason'      => 'Manual registration',
            'changed_by'  => auth()->id(),
            'created_at'  => now(),
        ]);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student created. ID: '.$student->student_id);
    }

    public function show(Student $student)
    {
        $student->load(['program.department', 'batch', 'currentSemester', 'user', 'notes.creator', 'statusHistory.changedBy', 'enrollments.semester', 'enrollments.section']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $programs = Program::with('department')->where('is_active', true)->orderBy('name')->get();
        $batches  = Batch::with('program')->where('is_active', true)->orderBy('name')->get();
        return view('students.edit', compact('student', 'programs', 'batches'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'gender'           => 'required|in:male,female,other',
            'dob'              => 'nullable|date',
            'blood_group'      => 'nullable|string|max:5',
            'phone'            => 'nullable|string|max:30',
            'email'            => 'nullable|email',
            'address'          => 'nullable|string',
            'program_id'       => 'required|exists:programs,id',
            'batch_id'         => 'required|exists:batches,id',
            'admission_date'   => 'required|date',
            'guardian_name'    => 'nullable|string|max:200',
            'guardian_phone'   => 'nullable|string|max:30',
            'guardian_relation'=> 'nullable|string|max:50',
            'photo'            => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo) Storage::disk('public')->delete($student->photo);
            $validated['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        $oldStatus = $student->status;
        $newStatus = $request->input('status', $student->status);

        $student->update($validated + ['status' => $newStatus]);

        if ($oldStatus !== $newStatus) {
            StudentStatusHistory::create([
                'student_id' => $student->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'reason'     => $request->status_reason,
                'changed_by' => auth()->id(),
                'created_at' => now(),
            ]);
        }

        return redirect()->route('students.show', $student)->with('success', 'Student updated.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted.');
    }

    public function storeNote(Request $request, Student $student)
    {
        $request->validate(['note' => 'required|string']);
        StudentNote::create([
            'student_id' => $student->id,
            'note'       => $request->note,
            'created_by' => auth()->id(),
        ]);
        return back()->with('success', 'Note added.');
    }
}
