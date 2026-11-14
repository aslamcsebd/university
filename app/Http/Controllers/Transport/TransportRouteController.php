<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use App\Models\TransportRoute;
use App\Models\TransportStop;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class TransportRouteController extends Controller
{
    public function index()
    {
        $routes   = TransportRoute::with(['vehicle', 'stops'])->withCount('allocations')->latest()->get();
        $vehicles = Vehicle::where('is_active', true)->orderBy('plate_no')->get();
        return view('facilities.routes', compact('routes', 'vehicles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'name'          => 'required|string|max:200',
            'from_location' => 'required|string|max:200',
            'to_location'   => 'required|string|max:200',
            'fare'          => 'required|numeric|min:0',
        ]);
        TransportRoute::create($data);
        return back()->with('success', 'Route added.');
    }

    public function update(Request $request, TransportRoute $route)
    {
        $data = $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'name'          => 'required|string|max:200',
            'from_location' => 'required|string|max:200',
            'to_location'   => 'required|string|max:200',
            'fare'          => 'required|numeric|min:0',
            'is_active'     => 'boolean',
        ]);
        $route->update($data);
        return back()->with('success', 'Route updated.');
    }

    public function destroy(TransportRoute $route)
    {
        if ($route->allocations()->where('is_active', true)->exists()) {
            return back()->with('error', 'Cannot delete route with active allocations.');
        }
        $route->stops()->delete();
        $route->delete();
        return back()->with('success', 'Route deleted.');
    }

    public function storeStop(Request $request, TransportRoute $route)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'order'       => 'required|integer|min:1',
            'pickup_time' => 'nullable|date_format:H:i',
        ]);
        $route->stops()->create($data);
        return back()->with('success', 'Stop added.');
    }

    public function destroyStop(TransportRoute $route, TransportStop $stop)
    {
        $stop->delete();
        return back()->with('success', 'Stop removed.');
    }
}
