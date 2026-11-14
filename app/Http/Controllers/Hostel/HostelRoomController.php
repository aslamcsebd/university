<?php

namespace App\Http\Controllers\Hostel;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\HostelRoom;
use App\Models\HostelRoomType;
use Illuminate\Http\Request;

class HostelRoomController extends Controller
{
    public function index(Request $request)
    {
        $query = HostelRoom::with(['hostel', 'roomType']);
        if ($request->filled('hostel')) {
            $query->where('hostel_id', $request->hostel);
        }
        $rooms    = $query->orderBy('room_number')->paginate(20)->withQueryString();
        $hostels  = Hostel::where('is_active', true)->orderBy('name')->get();
        $types    = HostelRoomType::orderBy('name')->get();
        return view('facilities.hostel-rooms', compact('rooms', 'hostels', 'types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hostel_id'    => 'required|exists:hostels,id',
            'room_type_id' => 'required|exists:hostel_room_types,id',
            'room_number'  => 'required|string|max:20',
            'floor'        => 'nullable|string|max:20',
            'capacity'     => 'required|integer|min:1',
        ]);
        HostelRoom::create($data);
        return back()->with('success', 'Room added.');
    }

    public function update(Request $request, HostelRoom $hostelRoom)
    {
        $data = $request->validate([
            'room_type_id' => 'required|exists:hostel_room_types,id',
            'room_number'  => 'required|string|max:20',
            'floor'        => 'nullable|string|max:20',
            'capacity'     => 'required|integer|min:1',
            'is_available' => 'boolean',
        ]);
        $hostelRoom->update($data);
        return back()->with('success', 'Room updated.');
    }

    public function destroy(HostelRoom $hostelRoom)
    {
        if ($hostelRoom->activeAllocations()->exists()) {
            return back()->with('error', 'Cannot delete room with active allocations.');
        }
        $hostelRoom->delete();
        return back()->with('success', 'Room deleted.');
    }
}
