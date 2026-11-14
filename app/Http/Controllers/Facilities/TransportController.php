<?php

namespace App\Http\Controllers\Facilities;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\TransportRoute;
use App\Models\TransportStop;
use App\Models\TransportAllocation;
use App\Models\Student;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::withCount('routes')->orderBy('plate_no')->get();
        $routes   = TransportRoute::with(['vehicle','stops'])->withCount('allocations')->get();
        return view('facilities.transport', compact('vehicles','routes'));
    }

    public function storeVehicle(Request $request)
    {
        $validated = $request->validate([
            'plate_no' => 'required|string|max:30|unique:vehicles,plate_no',
            'type'     => 'required|in:bus,van,car',
            'capacity' => 'required|integer|min:1',
            'model'    => 'nullable|string|max:100',
            'year'     => 'nullable|integer|min:1990|max:'.date('Y'),
        ]);
        Vehicle::create($validated);
        return back()->with('success', 'Vehicle added.');
    }

    public function storeRoute(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'name'          => 'required|string|max:255',
            'from_location' => 'nullable|string',
            'to_location'   => 'nullable|string',
            'fare'          => 'nullable|numeric|min:0',
        ]);
        TransportRoute::create($validated);
        return back()->with('success', 'Route created.');
    }

    public function storeStop(Request $request, TransportRoute $route)
    {
        $request->validate(['name'=>'required|string','pickup_time'=>'nullable|date_format:H:i']);
        TransportStop::create([
            'route_id'    => $route->id,
            'name'        => $request->name,
            'pickup_time' => $request->pickup_time,
            'order'       => $route->stops()->count() + 1,
        ]);
        return back()->with('success', 'Stop added.');
    }

    public function allocationsIndex()
    {
        $allocations = TransportAllocation::with('route.vehicle')->where('is_active',true)->paginate(20);
        $routes      = TransportRoute::where('is_active',true)->with('vehicle')->get();
        $students    = Student::active()->orderBy('first_name')->get();
        return view('facilities.transport-allocations', compact('allocations','routes','students'));
    }

    public function allocate(Request $request)
    {
        $validated = $request->validate([
            'route_id'    => 'required|exists:transport_routes,id',
            'person_id'   => 'required|string',
            'person_type' => 'required|in:student,staff',
            'start_date'  => 'required|date',
        ]);

        if (TransportAllocation::where('person_id',$validated['person_id'])->where('is_active',true)->exists()) {
            return back()->with('error','Person already allocated to a route.');
        }

        TransportAllocation::create($validated);
        return back()->with('success','Transport allocated.');
    }

    public function deallocate(TransportAllocation $allocation)
    {
        $allocation->update(['is_active'=>false,'end_date'=>now()]);
        return back()->with('success','Allocation removed.');
    }
}
