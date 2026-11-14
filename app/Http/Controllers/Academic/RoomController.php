<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Building;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with(['building.campus', 'roomType'])->latest();
        if ($request->filled('search'))   { $query->where('name', 'like', '%'.$request->search.'%'); }
        if ($request->filled('building')) { $query->where('building_id', $request->building); }
        $rooms     = $query->paginate(20)->withQueryString();
        $buildings = Building::with('campus')->where('is_active', true)->orderBy('name')->get();
        return view('academic.rooms.index', compact('rooms', 'buildings'));
    }

    public function create()
    {
        $buildings  = Building::with('campus')->where('is_active', true)->orderBy('name')->get();
        $roomTypes  = RoomType::orderBy('name')->get();
        return view('academic.rooms.create', compact('buildings', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'building_id'   => 'required|exists:buildings,id',
            'room_type_id'  => 'nullable|exists:room_types,id',
            'name'          => 'required|string|max:100',
            'floor'         => 'nullable|integer',
            'capacity'      => 'required|integer|min:1',
            'has_projector' => 'boolean',
            'has_ac'        => 'boolean',
            'is_active'     => 'boolean',
        ]);
        $validated['has_projector'] = $request->boolean('has_projector');
        $validated['has_ac']        = $request->boolean('has_ac');
        $validated['is_active']     = $request->boolean('is_active', true);
        Room::create($validated);
        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        $buildings = Building::with('campus')->where('is_active', true)->orderBy('name')->get();
        $roomTypes = RoomType::orderBy('name')->get();
        return view('academic.rooms.edit', compact('room', 'buildings', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'building_id'   => 'required|exists:buildings,id',
            'room_type_id'  => 'nullable|exists:room_types,id',
            'name'          => 'required|string|max:100',
            'floor'         => 'nullable|integer',
            'capacity'      => 'required|integer|min:1',
            'has_projector' => 'boolean',
            'has_ac'        => 'boolean',
            'is_active'     => 'boolean',
        ]);
        $validated['has_projector'] = $request->boolean('has_projector');
        $validated['has_ac']        = $request->boolean('has_ac');
        $validated['is_active']     = $request->boolean('is_active', true);
        $room->update($validated);
        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted.');
    }
}
