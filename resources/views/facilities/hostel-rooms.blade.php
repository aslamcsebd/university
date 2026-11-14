<x-app-layout>
    <x-slot name="title">Hostel Rooms</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hostel Rooms</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $rooms->total() }} rooms</p>
        </div>
        <button onclick="document.getElementById('add-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Room
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <form method="GET" class="flex gap-3 mb-4">
        <select name="hostel" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Hostels</option>
            @foreach($hostels as $h)
                <option value="{{ $h->id }}" {{ request('hostel') == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Room No</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Hostel</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Type</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Floor</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Capacity</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Occupied</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rooms as $room)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-bold text-gray-900">{{ $room->room_number }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $room->hostel->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $room->roomType->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $room->floor ?? '—' }}</td>
                    <td class="px-4 py-3 text-center font-bold text-gray-700">{{ $room->capacity }}</td>
                    <td class="px-4 py-3 text-center font-bold {{ $room->current_occupants >= $room->capacity ? 'text-red-600' : 'text-green-600' }}">
                        {{ $room->current_occupants }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $room->is_available ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            {{ $room->is_available ? 'Available' : 'Full' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="{{ route('hostel-rooms.destroy', $room) }}" onsubmit="return confirm('Delete room?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">No rooms found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $rooms->links() }}</div>
    </div>

    <div id="add-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="font-bold text-gray-900 mb-4">Add Room</h3>
            <form method="POST" action="{{ route('hostel-rooms.store') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Hostel *</label>
                        <select name="hostel_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select</option>
                            @foreach($hostels as $h)
                                <option value="{{ $h->id }}">{{ $h->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Room Type *</label>
                        <select name="room_type_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select</option>
                            @foreach($types as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Room Number *</label>
                        <input type="text" name="room_number" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Floor</label>
                        <input type="text" name="floor" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Capacity *</label>
                        <input type="number" name="capacity" min="1" value="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Room</button>
                    <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
