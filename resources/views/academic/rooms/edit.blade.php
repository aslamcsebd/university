<x-app-layout>
    <x-slot name="title">Edit Room</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('rooms.index')
        <a href="{{ route('rooms.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <div><h1 class="text-2xl font-bold text-gray-900">Edit Room</h1><p class="text-sm text-gray-500">{{ $room->name }}</p></div>
    </div>
    <div class="max-w-2xl">
        @access('rooms.update')
        <form method="POST" action="{{ route('rooms.update', $room) }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Building <span class="text-red-500">*</span></label>
                    <select name="building_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($buildings as $b)<option value="{{ $b->id }}" {{ old('building_id', $room->building_id) == $b->id ? 'selected' : '' }}>{{ $b->name }} ({{ $b->campus?->name }})</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                    <select name="room_type_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Type —</option>
                        @foreach($roomTypes as $rt)<option value="{{ $rt->id }}" {{ old('room_type_id', $room->room_type_id) == $rt->id ? 'selected' : '' }}>{{ $rt->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Name / Number <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $room->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Floor</label>
                    <input type="number" name="floor" value="{{ old('floor', $room->floor) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Capacity <span class="text-red-500">*</span></label>
                    <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" required min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex flex-col gap-2 justify-end">
                    <div class="flex items-center gap-2"><input type="checkbox" name="has_projector" value="1" {{ old('has_projector', $room->has_projector) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Has Projector</label></div>
                    <div class="flex items-center gap-2"><input type="checkbox" name="has_ac" value="1" {{ old('has_ac', $room->has_ac) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Has AC</label></div>
                    <div class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $room->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Active</label></div>
                </div>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update Room</button>
                @access('rooms.index')
                <a href="{{ route('rooms.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
                @endaccess
            </div>
        </form>
                @endaccess
    </div>
</x-app-layout>
