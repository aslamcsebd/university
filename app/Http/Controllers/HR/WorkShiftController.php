<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\WorkShift;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    public function index()
    {
        $shifts = WorkShift::withCount('staff')->orderBy('name')->paginate(20);
        return view('hr.shifts.index', compact('shifts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100|unique:work_shifts,name',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i|after:start_time',
            'grace_minutes' => 'nullable|integer|min:0|max:60',
        ]);
        $validated['grace_minutes'] = $validated['grace_minutes'] ?? 10;
        WorkShift::create($validated);
        return back()->with('success', 'Work shift added.');
    }

    public function update(Request $request, WorkShift $shift)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100|unique:work_shifts,name,'.$shift->id,
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i|after:start_time',
            'grace_minutes' => 'nullable|integer|min:0|max:60',
        ]);
        $shift->update($validated);
        return back()->with('success', 'Work shift updated.');
    }

    public function destroy(WorkShift $shift)
    {
        if ($shift->staff()->count() > 0) {
            return back()->with('error', 'Cannot delete shift with assigned staff.');
        }
        $shift->delete();
        return back()->with('success', 'Work shift deleted.');
    }
}
