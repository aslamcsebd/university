<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::withCount('applications')->orderBy('name')->paginate(20);
        return view('hr.leave-types.index', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100|unique:leave_types,name',
            'days_allowed'  => 'required|integer|min:0',
            'applies_to'    => 'required|in:staff,student,all',
            'is_paid'       => 'boolean',
            'carry_forward' => 'boolean',
        ]);
        $validated['is_paid']       = $request->boolean('is_paid', true);
        $validated['carry_forward'] = $request->boolean('carry_forward');
        LeaveType::create($validated);
        return back()->with('success', 'Leave type added.');
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100|unique:leave_types,name,'.$leaveType->id,
            'days_allowed'  => 'required|integer|min:0',
            'applies_to'    => 'required|in:staff,student,all',
            'is_paid'       => 'boolean',
            'carry_forward' => 'boolean',
        ]);
        $validated['is_paid']       = $request->boolean('is_paid', true);
        $validated['carry_forward'] = $request->boolean('carry_forward');
        $leaveType->update($validated);
        return back()->with('success', 'Leave type updated.');
    }

    public function destroy(LeaveType $leaveType)
    {
        if ($leaveType->applications()->count() > 0) {
            return back()->with('error', 'Cannot delete leave type with existing applications.');
        }
        $leaveType->delete();
        return back()->with('success', 'Leave type deleted.');
    }
}
