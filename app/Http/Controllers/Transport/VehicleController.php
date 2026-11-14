<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Staff;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('driver')->latest()->get();
        $drivers  = Staff::where('is_active', true)->orderBy('first_name')->get();
        return view('facilities.vehicles', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plate_no'  => 'required|string|max:30|unique:vehicles,plate_no',
            'type'      => 'required|in:bus,van,car',
            'capacity'  => 'required|integer|min:1',
            'model'     => 'nullable|string|max:100',
            'year'      => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
            'driver_id' => 'nullable|exists:staff,id',
        ]);
        Vehicle::create($data);
        return back()->with('success', 'Vehicle added.');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'plate_no'  => 'required|string|max:30|unique:vehicles,plate_no,' . $vehicle->id,
            'type'      => 'required|in:bus,van,car',
            'capacity'  => 'required|integer|min:1',
            'model'     => 'nullable|string|max:100',
            'year'      => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
            'driver_id' => 'nullable|exists:staff,id',
            'is_active' => 'boolean',
        ]);
        $vehicle->update($data);
        return back()->with('success', 'Vehicle updated.');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->routes()->exists()) {
            return back()->with('error', 'Cannot delete vehicle with active routes.');
        }
        $vehicle->delete();
        return back()->with('success', 'Vehicle deleted.');
    }
}
