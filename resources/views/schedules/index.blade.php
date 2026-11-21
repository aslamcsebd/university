<x-app-layout>
    <x-slot name="title">Class Schedules</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Class Schedules</h1><p class="text-sm text-gray-500 mt-1">Weekly class timetable</p></div>
        @access('schedules.create')
        <a href="{{ route('schedules.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Schedule
        </a>
        @endaccess
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex gap-3">
            <select name="semester_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Semesters</option>
                @foreach($semesters as $s)<option value="{{ $s->id }}" {{ request('semester_id')==$s->id || $semester?->id==$s->id ? 'selected':'' }}>{{ $s->name }} ({{ $s->academicSession?->name }}) {{ $s->is_current ? '★':'' }}</option>@endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">View</button>
        </form>
    </div>
    @if($semester)<p class="text-sm text-blue-600 mb-4 font-medium">Showing: {{ $semester->name }}</p>@endif
    @php $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']; @endphp
    @foreach($days as $dayNum => $dayName)
        @php $daySchedules = $schedules->where('day_of_week', $dayNum); @endphp
        @if($daySchedules->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-4">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100"><h3 class="font-semibold text-gray-900">{{ $dayName }}</h3></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Time</th><th class="text-left px-5 py-2 font-medium text-gray-600">Course</th><th class="text-left px-5 py-2 font-medium text-gray-600">Section</th><th class="text-left px-5 py-2 font-medium text-gray-600">Room</th><th class="text-right px-5 py-2 font-medium text-gray-600">Action</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($daySchedules->sortBy('start_time') as $sch)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 text-gray-700 font-medium">{{ $sch->start_time }} – {{ $sch->end_time }}</td>
                        <td class="px-5 py-2"><p class="font-medium text-gray-900">{{ $sch->sessionCourse?->course?->name }}</p><p class="text-xs text-gray-400">{{ $sch->sessionCourse?->course?->code }}</p></td>
                        <td class="px-5 py-2 text-gray-500">{{ $sch->sessionCourse?->section?->name ?? '—' }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $sch->room?->name ?? '—' }}</td>
                        <td class="px-5 py-2 text-right">
                            @access('schedules.destroy')
                            <form method="POST" action="{{ route('schedules.destroy', $sch) }}" onsubmit="return confirm('Remove?')">@csrf @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">Remove</button>
                            </form>
                            @endaccess
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    @endforeach
    @if($schedules->isEmpty())<div class="bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-400">No schedules yet. @access('schedules.create')
<a href="{{ route('schedules.create') }}" class="text-blue-600">Add one →</a>
@endaccess</div>@endif
</x-app-layout>
