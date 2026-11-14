<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication;
use App\Models\LeaveType;
use App\Models\LeaveBalance;
use App\Models\Staff;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveApplication::with(['applicant', 'leaveType'])->latest();

        if ($request->filled('status'))     { $query->where('status', $request->status); }
        if ($request->filled('leave_type')) { $query->where('leave_type_id', $request->leave_type); }

        $applications = $query->paginate(20)->withQueryString();
        $leaveTypes   = LeaveType::where('is_active', true)->get();

        return view('hr.leave.index', compact('applications', 'leaveTypes'));
    }

    public function approve(LeaveApplication $application)
    {
        if ($application->status !== 'pending') {
            return back()->with('error', 'Only pending applications can be approved.');
        }

        $application->update([
            'status'      => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Deduct from leave balance if staff
        $staff = Staff::where('user_id', $application->applicant_id)->first();
        if ($staff) {
            LeaveBalance::updateOrCreate(
                ['staff_id' => $staff->id, 'leave_type_id' => $application->leave_type_id, 'year' => now()->year],
                ['entitlement' => $application->leaveType->days_allowed, 'used' => 0, 'balance' => $application->leaveType->days_allowed]
            );
            LeaveBalance::where('staff_id', $staff->id)
                ->where('leave_type_id', $application->leave_type_id)
                ->where('year', now()->year)
                ->increment('used', $application->days_count);
            LeaveBalance::where('staff_id', $staff->id)
                ->where('leave_type_id', $application->leave_type_id)
                ->where('year', now()->year)
                ->decrement('balance', $application->days_count);
        }

        return back()->with('success', 'Leave approved.');
    }

    public function reject(Request $request, LeaveApplication $application)
    {
        $request->validate(['review_notes' => 'nullable|string']);

        $application->update([
            'status'       => 'rejected',
            'reviewed_by'  => auth()->id(),
            'reviewed_at'  => now(),
            'review_notes' => $request->review_notes,
        ]);

        return back()->with('success', 'Leave rejected.');
    }
}
