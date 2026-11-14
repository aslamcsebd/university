<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\AdmissionStatus;
use Illuminate\Http\Request;

class AdmissionStatusController extends Controller
{
    public function index()
    {
        $statuses = AdmissionStatus::withCount('applications')->orderBy('order')->get();
        return view('admission.statuses', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:100|unique:admission_statuses,name',
            'color'              => 'required|string|max:20',
            'description'        => 'nullable|string',
            'is_approval_trigger'=> 'boolean',
            'order'              => 'nullable|integer|min:0',
        ]);
        $validated['is_approval_trigger'] = $request->boolean('is_approval_trigger');
        $validated['order'] = $validated['order'] ?? AdmissionStatus::max('order') + 1;
        AdmissionStatus::create($validated);
        return back()->with('success', 'Status added.');
    }

    public function update(Request $request, AdmissionStatus $status)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:100|unique:admission_statuses,name,'.$status->id,
            'color'              => 'required|string|max:20',
            'is_approval_trigger'=> 'boolean',
        ]);
        $validated['is_approval_trigger'] = $request->boolean('is_approval_trigger');
        $status->update($validated);
        return back()->with('success', 'Status updated.');
    }

    public function destroy(AdmissionStatus $status)
    {
        if ($status->applications()->count() > 0) {
            return back()->with('error', 'Cannot delete status with applications.');
        }
        $status->delete();
        return back()->with('success', 'Status deleted.');
    }
}
