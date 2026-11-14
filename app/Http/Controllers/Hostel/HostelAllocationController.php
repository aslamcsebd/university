<?php

namespace App\Http\Controllers\Hostel;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\HostelAllocation;
use App\Models\HostelRoom;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;

class HostelAllocationController extends Controller
{
    public function studentIndex(Request $request)
    {
        $allocations = HostelAllocation::with(['room.hostel', 'room.roomType'])
            ->where('person_type', 'student')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(20)->withQueryString();

        $allocations->getCollection()->transform(function ($a) {
            $a->person = Student::find($a->person_id);
            return $a;
        });

        $rooms    = HostelRoom::with('hostel')->where('is_available', true)->get();
        $students = Student::orderBy('first_name')->get();
        return view('facilities.hostel-students', compact('allocations', 'rooms', 'students'));
    }

    public function staffIndex(Request $request)
    {
        $allocations = HostelAllocation::with(['room.hostel', 'room.roomType'])
            ->where('person_type', 'staff')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(20)->withQueryString();

        $allocations->getCollection()->transform(function ($a) {
            $a->person = Staff::find($a->person_id);
            return $a;
        });

        $rooms     = HostelRoom::with('hostel')->where('is_available', true)->get();
        $staffList = Staff::where('is_active', true)->orderBy('first_name')->get();
        return view('facilities.hostel-staff', compact('allocations', 'rooms', 'staffList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'      => 'required|exists:hostel_rooms,id',
            'person_id'    => 'required|integer',
            'person_type'  => 'required|in:student,staff',
            'move_in_date' => 'required|date',
            'notes'        => 'nullable|string|max:500',
        ]);

        $room = HostelRoom::findOrFail($data['room_id']);

        if ($room->current_occupants >= $room->capacity) {
            return back()->with('error', 'Room is full.');
        }

        $existing = HostelAllocation::where('person_id', $data['person_id'])
            ->where('person_type', $data['person_type'])
            ->where('status', 'active')->exists();
        if ($existing) {
            return back()->with('error', 'Person already has an active allocation.');
        }

        HostelAllocation::create($data + ['status' => 'active']);
        $room->increment('current_occupants');
        if ($room->current_occupants >= $room->capacity) {
            $room->update(['is_available' => false]);
        }

        return back()->with('success', 'Allocated successfully.');
    }

    public function vacate(HostelAllocation $allocation)
    {
        $allocation->update(['status' => 'vacated', 'move_out_date' => today()]);
        $room = $allocation->room;
        $room->decrement('current_occupants');
        $room->update(['is_available' => true]);
        return back()->with('success', 'Vacated successfully.');
    }
}
