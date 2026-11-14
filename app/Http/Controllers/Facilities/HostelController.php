<?php

namespace App\Http\Controllers\Facilities;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\HostelRoom;
use App\Models\HostelRoomType;
use App\Models\HostelAllocation;
use App\Models\Campus;
use App\Models\Student;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index()
    {
        $hostels   = Hostel::withCount('rooms')->with('campus')->get();
        $campuses  = Campus::where('is_active',true)->get();
        $roomTypes = HostelRoomType::all();
        return view('facilities.hostel', compact('hostels','campuses','roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:hostels,name',
            'campus_id' => 'nullable|exists:campuses,id',
            'type'      => 'required|in:male,female,mixed',
        ]);
        Hostel::create($validated);
        return back()->with('success', 'Hostel created.');
    }

    public function roomsIndex(Hostel $hostel)
    {
        $rooms     = $hostel->rooms()->with('roomType')->paginate(20);
        $roomTypes = HostelRoomType::all();
        return view('facilities.hostel-rooms', compact('hostel','rooms','roomTypes'));
    }

    public function storeRoom(Request $request, Hostel $hostel)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:50',
            'room_type_id'=> 'nullable|exists:hostel_room_types,id',
            'floor'       => 'nullable|integer|min:0',
            'capacity'    => 'required|integer|min:1',
        ]);
        $validated['hostel_id'] = $hostel->id;
        HostelRoom::create($validated);
        return back()->with('success', 'Room added.');
    }

    public function allocationsIndex()
    {
        $allocations = HostelAllocation::with('room.hostel')->latest()->paginate(20);
        $rooms       = HostelRoom::where('is_available',true)->with('hostel')->get();
        $students    = Student::active()->orderBy('first_name')->get();
        return view('facilities.hostel-allocations', compact('allocations','rooms','students'));
    }

    public function allocate(Request $request)
    {
        $validated = $request->validate([
            'room_id'      => 'required|exists:hostel_rooms,id',
            'person_id'    => 'required|string',
            'person_type'  => 'required|in:student,staff',
            'move_in_date' => 'required|date',
        ]);

        $room = HostelRoom::findOrFail($validated['room_id']);
        if ($room->current_occupants >= $room->capacity) {
            return back()->with('error', 'Room is full.');
        }

        // Check not already allocated
        if (HostelAllocation::where('person_id',$validated['person_id'])->where('status','active')->exists()) {
            return back()->with('error', 'Person already has an active allocation.');
        }

        HostelAllocation::create($validated);
        $room->increment('current_occupants');
        if ($room->current_occupants >= $room->capacity) $room->update(['is_available'=>false]);

        return back()->with('success', 'Hostel allocated.');
    }

    public function vacate(HostelAllocation $allocation)
    {
        $allocation->update(['status'=>'vacated','move_out_date'=>now()]);
        $room = $allocation->room;
        $room->decrement('current_occupants');
        $room->update(['is_available'=>true]);
        return back()->with('success', 'Hostel vacated.');
    }

    public function storeRoomType(Request $request)
    {
        $request->validate(['name'=>'required|string|max:100|unique:hostel_room_types,name','capacity'=>'required|integer|min:1']);
        HostelRoomType::create($request->only('name','capacity','description'));
        return back()->with('success', 'Room type added.');
    }
}
