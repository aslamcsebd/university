<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Department;
use App\Models\Designation;
use App\Models\WorkShift;
use App\Models\User;
use App\Services\AccessManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::with(['department', 'designation'])->teachers()->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%')
                  ->orWhere('employee_id', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('department')) { $query->where('department_id', $request->department); }
        if ($request->filled('status'))     { $query->where('is_active', $request->status === 'active'); }

        $teachers     = $query->paginate(20)->withQueryString();
        $departments  = Department::where('is_active', true)->orderBy('name')->get();

        return view('hr.teachers.index', compact('teachers', 'departments'));
    }

    public function create()
    {
        $departments  = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('name')->get();
        $workShifts   = WorkShift::where('is_active', true)->orderBy('name')->get();
        $employeeId   = Staff::generateEmployeeId();

        return view('hr.teachers.create', compact('departments', 'designations', 'workShifts', 'employeeId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'employee_id'     => 'required|string|max:50|unique:staff,employee_id',
            'gender'          => 'required|in:male,female,other',
            'dob'             => 'nullable|date',
            'phone'           => 'nullable|string|max:30',
            'personal_email'  => 'nullable|email',
            'address'         => 'nullable|string',
            'department_id'   => 'required|exists:departments,id',
            'designation_id'  => 'required|exists:designations,id',
            'work_shift_id'   => 'nullable|exists:work_shifts,id',
            'employment_type' => 'required|in:permanent,contract,part_time,visiting',
            'join_date'       => 'required|date',
            'highest_degree'  => 'nullable|string',
            'specialization'  => 'nullable|string',
            'experience_years'=> 'nullable|integer|min:0',
            'photo'           => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:8',
        ]);

        // Always create user account for teachers
        app(AccessManagement::class)->validateDefaultRole($request->user(), 'teacher');
        $user = User::create([
            'name'              => $validated['first_name'].' '.$validated['last_name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $user->assignRole('teacher');

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('staff/photos', 'public');
        }

        $validated['user_id']    = $user->id;
        $validated['is_teacher'] = true;
        $validated['is_active']  = $request->boolean('is_active', true);

        unset($validated['email'], $validated['password']);
        Staff::create($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function show(Staff $teacher)
    {
        $teacher->load(['department', 'designation', 'workShift', 'user']);
        return view('hr.teachers.show', compact('teacher'));
    }

    public function edit(Staff $teacher)
    {
        $departments  = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('name')->get();
        $workShifts   = WorkShift::where('is_active', true)->orderBy('name')->get();
        return view('hr.teachers.edit', compact('teacher', 'departments', 'designations', 'workShifts'));
    }

    public function update(Request $request, Staff $teacher)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'employee_id'     => 'required|string|max:50|unique:staff,employee_id,'.$teacher->id,
            'gender'          => 'required|in:male,female,other',
            'dob'             => 'nullable|date',
            'phone'           => 'nullable|string|max:30',
            'personal_email'  => 'nullable|email',
            'address'         => 'nullable|string',
            'department_id'   => 'required|exists:departments,id',
            'designation_id'  => 'required|exists:designations,id',
            'work_shift_id'   => 'nullable|exists:work_shifts,id',
            'employment_type' => 'required|in:permanent,contract,part_time,visiting',
            'join_date'       => 'required|date',
            'highest_degree'  => 'nullable|string',
            'specialization'  => 'nullable|string',
            'experience_years'=> 'nullable|integer|min:0',
            'photo'           => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('photo')) {
            if ($teacher->photo) Storage::disk('public')->delete($teacher->photo);
            $validated['photo'] = $request->file('photo')->store('staff/photos', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $teacher->update($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Staff $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted.');
    }
}
