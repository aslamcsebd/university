<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::withCount('staff')->orderBy('name')->paginate(20);
        return view('hr.designations.index', compact('designations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:designations,name',
            'description' => 'nullable|string',
        ]);
        Designation::create($validated);
        return back()->with('success', 'Designation added.');
    }

    public function update(Request $request, Designation $designation)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:designations,name,'.$designation->id,
            'description' => 'nullable|string',
        ]);
        $designation->update($validated);
        return back()->with('success', 'Designation updated.');
    }

    public function destroy(Designation $designation)
    {
        if ($designation->staff()->count() > 0) {
            return back()->with('error', 'Cannot delete designation with assigned staff.');
        }
        $designation->delete();
        return back()->with('success', 'Designation deleted.');
    }
}
