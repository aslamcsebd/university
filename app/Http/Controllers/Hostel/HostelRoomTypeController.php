<?php

namespace App\Http\Controllers\Hostel;

use App\Http\Controllers\Controller;
use App\Models\HostelRoomType;
use Illuminate\Http\Request;

class HostelRoomTypeController extends Controller
{
    public function index()
    {
        $types = HostelRoomType::withCount('rooms')->orderBy('name')->get();
        return view('facilities.room-types', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:hostel_room_types,name',
            'capacity'    => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);
        HostelRoomType::create($data);
        return back()->with('success', 'Room type added.');
    }

    public function update(Request $request, HostelRoomType $roomType)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:hostel_room_types,name,' . $roomType->id,
            'capacity'    => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);
        $roomType->update($data);
        return back()->with('success', 'Room type updated.');
    }

    public function destroy(HostelRoomType $roomType)
    {
        if ($roomType->rooms()->exists()) {
            return back()->with('error', 'Cannot delete type with rooms.');
        }
        $roomType->delete();
        return back()->with('success', 'Room type deleted.');
    }
}
