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

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::with(['department', 'designation'])->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%')
                  ->orWhere('employee_id', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('department'))  { $query->where('department_id', $request->department); }
        if ($request->filled('designation')) { $query->where('designation_id', $request->designation); }
        if ($request->filled('type'))        { $query->where('employment_type', $request->type); }
        if ($request->filled('status'))      { $query->where('is_active', $request->status === 'active'); }

        $staff        = $query->where('is_teacher', false)->paginate(20)->withQueryString();
        $departments  = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('name')->get();

        return view('hr.staff.index', compact('staff', 'departments', 'designations'));
    }

    public function create()
    {
        $departments  = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('name')->get();
        $workShifts   = WorkShift::where('is_active', true)->orderBy('name')->get();
        $employeeId   = Staff::generateEmployeeId();

        return view('hr.staff.create', compact('departments', 'designations', 'workShifts', 'employeeId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'employee_id'     => 'required|string|max:50|unique:staff,employee_id',
            'gender'          => 'required|in:male,female,other',
            'dob'             => 'nullable|date',
            'blood_group'     => 'nullable|string|max:5',
            'phone'           => 'nullable|string|max:30',
            'personal_email'  => 'nullable|email',
            'address'         => 'nullable|string',
            'department_id'   => 'required|exists:departments,id',
            'designation_id'  => 'required|exists:designations,id',
            'work_shift_id'   => 'nullable|exists:work_shifts,id',
            'employment_type' => 'required|in:permanent,contract,part_time,visiting',
            'join_date'       => 'required|date',
            'contract_end_date' => 'nullable|date|after:join_date',
            'highest_degree'  => 'nullable|string',
            'institution'     => 'nullable|string',
            'experience_years'=> 'nullable|integer|min:0',
            'photo'           => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
            // User account
            'create_account'  => 'boolean',
            'email'           => 'nullable|required_if:create_account,1|email|unique:users,email',
            'password'        => 'nullable|required_if:create_account,1|min:8',
        ]);

        $userId = null;
        if ($request->boolean('create_account') && $request->filled('email')) {
            app(AccessManagement::class)->validateDefaultRole($request->user(), 'teacher');
            $user   = User::create([
                'name'              => $validated['first_name'].' '.$validated['last_name'],
                'email'             => $validated['email'],
                'password'          => Hash::make($validated['password']),
                'is_active'         => true,
                'email_verified_at' => now(),
            ]);
            $user->assignRole('teacher');
            $userId = $user->id;
        }

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('staff/photos', 'public');
        }

        $validated['user_id']   = $userId;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_teacher'] = false;

        Staff::create($validated);

        return redirect()->route('staff.index')->with('success', 'Staff member created successfully.');
    }

    public function show(Staff $staff)
    {
        $staff->load(['department', 'designation', 'workShift', 'user', 'notes.creator', 'leaveBalances.leaveType']);
        $recentLeaves = $staff->leaveApplications()->with('leaveType')->latest()->take(5)->get();
        $payrolls     = $staff->payrolls()->orderByDesc('year')->orderByDesc('month')->take(6)->get();
        return view('hr.staff.show', compact('staff', 'recentLeaves', 'payrolls'));
    }

    public function edit(Staff $staff)
    {
        $departments  = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('name')->get();
        $workShifts   = WorkShift::where('is_active', true)->orderBy('name')->get();
        return view('hr.staff.edit', compact('staff', 'departments', 'designations', 'workShifts'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'employee_id'      => 'required|string|max:50|unique:staff,employee_id,'.$staff->id,
            'gender'           => 'required|in:male,female,other',
            'dob'              => 'nullable|date',
            'blood_group'      => 'nullable|string|max:5',
            'phone'            => 'nullable|string|max:30',
            'personal_email'   => 'nullable|email',
            'address'          => 'nullable|string',
            'department_id'    => 'required|exists:departments,id',
            'designation_id'   => 'required|exists:designations,id',
            'work_shift_id'    => 'nullable|exists:work_shifts,id',
            'employment_type'  => 'required|in:permanent,contract,part_time,visiting',
            'join_date'        => 'required|date',
            'contract_end_date'=> 'nullable|date',
            'highest_degree'   => 'nullable|string',
            'institution'      => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'photo'            => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('photo')) {
            if ($staff->photo) Storage::disk('public')->delete($staff->photo);
            $validated['photo'] = $request->file('photo')->store('staff/photos', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $staff->update($validated);

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->payrolls()->count() > 0) {
            return back()->with('error', 'Cannot delete staff with payroll history.');
        }
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted.');
    }

    public function toggleStatus(Staff $staff)
    {
        $staff->update(['is_active' => !$staff->is_active]);
        return back()->with('success', 'Staff status updated.');
    }
}
