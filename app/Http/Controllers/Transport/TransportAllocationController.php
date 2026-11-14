<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use App\Models\TransportAllocation;
use App\Models\TransportRoute;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;

class TransportAllocationController extends Controller
{
    public function studentIndex(Request $request)
    {
        $allocations = TransportAllocation::with(['route.vehicle', 'stop'])
            ->where('person_type', 'student')
            ->when($request->status, fn($q) => $q->where('is_active', $request->status === 'active'))
            ->latest()->paginate(20)->withQueryString();

        $allocations->getCollection()->transform(function ($a) {
            $a->person = Student::find($a->person_id);
            return $a;
        });

        $routes   = TransportRoute::with('stops')->where('is_active', true)->get();
        $students = Student::orderBy('first_name')->get();
        return view('facilities.transport-students', compact('allocations', 'routes', 'students'));
    }

    public function staffIndex(Request $request)
    {
        $allocations = TransportAllocation::with(['route.vehicle', 'stop'])
            ->where('person_type', 'staff')
            ->when($request->status, fn($q) => $q->where('is_active', $request->status === 'active'))
            ->latest()->paginate(20)->withQueryString();

        $allocations->getCollection()->transform(function ($a) {
            $a->person = Staff::find($a->person_id);
            return $a;
        });

        $routes    = TransportRoute::with('stops')->where('is_active', true)->get();
        $staffList = Staff::where('is_active', true)->orderBy('first_name')->get();
        return view('facilities.transport-staff', compact('allocations', 'routes', 'staffList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'route_id'    => 'required|exists:transport_routes,id',
            'person_id'   => 'required|integer',
            'person_type' => 'required|in:student,staff',
            'stop_id'     => 'nullable|exists:transport_stops,id',
            'start_date'  => 'required|date',
        ]);

        $route = TransportRoute::with('vehicle')->findOrFail($data['route_id']);
        $activeCount = TransportAllocation::where('route_id', $route->id)->where('is_active', true)->count();
        if ($activeCount >= $route->vehicle->capacity) {
            return back()->with('error', 'Route is at full capacity.');
        }

        $existing = TransportAllocation::where('person_id', $data['person_id'])
            ->where('person_type', $data['person_type'])
            ->where('is_active', true)->exists();
        if ($existing) {
            return back()->with('error', 'Person already has an active transport allocation.');
        }

        TransportAllocation::create($data + ['is_active' => true]);
        return back()->with('success', 'Transport allocated.');
    }

    public function deactivate(TransportAllocation $allocation)
    {
        $allocation->update(['is_active' => false, 'end_date' => today()]);
        return back()->with('success', 'Allocation deactivated.');
    }
}
