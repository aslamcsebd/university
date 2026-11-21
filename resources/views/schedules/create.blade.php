<x-app-layout>
    <x-slot name="title">Add Class Schedule</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('schedules.index')
        <a href="{{ route('schedules.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <h1 class="text-2xl font-bold text-gray-900">Add Class Schedule</h1>
    </div>
    @if($errors->has('conflict'))<div class="max-w-2xl mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">⚠️ {{ $errors->first('conflict') }}</div>@endif
    <div class="max-w-2xl">
        @access('schedules.store')
        <form method="POST" action="{{ route('schedules.store') }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Course (Session Course) <span class="text-red-500">*</span></label>
                <select name="session_course_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Select Course —</option>
                    @foreach($sessionCourses as $sc)<option value="{{ $sc->id }}" {{ old('session_course_id')==$sc->id?'selected':'' }}>{{ $sc->course?->name }} ({{ $sc->course?->code }}) — {{ $sc->section?->name ?? 'No Section' }}</option>@endforeach
                </select>@error('session_course_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Day <span class="text-red-500">*</span></label>
                <select name="day_of_week" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($days as $num => $name)<option value="{{ $num }}" {{ old('day_of_week')==$num?'selected':'' }}>{{ $name }}</option>@endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Start Time <span class="text-red-500">*</span></label><input type="time" name="start_time" value="{{ old('start_time') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">End Time <span class="text-red-500">*</span></label><input type="time" name="end_time" value="{{ old('end_time') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Room</label>
                <select name="room_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— No Room —</option>
                    @foreach($rooms as $room)<option value="{{ $room->id }}" {{ old('room_id')==$room->id?'selected':'' }}>{{ $room->name }} ({{ $room->building?->name }}) — Cap: {{ $room->capacity }}</option>@endforeach
                </select>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Create Schedule</button>
                @access('schedules.index')
                <a href="{{ route('schedules.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
                @endaccess
            </div>
        </form>
                @endaccess
    </div>
</x-app-layout>
