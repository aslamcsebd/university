<?php

namespace App\Http\Controllers\Hostel;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\Campus;
use App\Models\Staff;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index()
    {
        $hostels  = Hostel::with(['campus', 'warden'])->withCount('rooms')->latest()->get();
        $campuses = Campus::where('is_active', true)->orderBy('name')->get();
        $wardens  = Staff::where('is_active', true)->orderBy('first_name')->get();
        return view('facilities.hostel-list', compact('hostels', 'campuses', 'wardens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'type'        => 'required|in:male,female,mixed',
            'campus_id'   => 'nullable|exists:campuses,id',
            'warden_id'   => 'nullable|exists:staff,id',
            'description' => 'nullable|string',
        ]);
        Hostel::create($data);
        return back()->with('success', 'Hostel added.');
    }

    public function update(Request $request, Hostel $hostel)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'type'        => 'required|in:male,female,mixed',
            'campus_id'   => 'nullable|exists:campuses,id',
            'warden_id'   => 'nullable|exists:staff,id',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $hostel->update($data);
        return back()->with('success', 'Hostel updated.');
    }

    public function destroy(Hostel $hostel)
    {
        if ($hostel->rooms()->exists()) {
            return back()->with('error', 'Cannot delete hostel with rooms.');
        }
        $hostel->delete();
        return back()->with('success', 'Hostel deleted.');
    }
}
