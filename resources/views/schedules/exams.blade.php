<x-app-layout>
    <x-slot name="title">Exam Schedules</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Exam Schedules</h1><p class="text-sm text-gray-500 mt-1">Manage examination timetables</p></div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Exam Timetable {{ $semester ? '— '.$semester->name : '' }}</h2></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Date</th><th class="text-left px-5 py-2 font-medium text-gray-600">Course</th><th class="text-left px-5 py-2 font-medium text-gray-600">Time</th><th class="text-left px-5 py-2 font-medium text-gray-600">Room</th><th class="text-left px-5 py-2 font-medium text-gray-600">Status</th><th class="text-right px-5 py-2 font-medium text-gray-600">Actions</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($schedules as $sch)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 font-medium text-gray-900">{{ $sch->date->format('d M Y') }}</td>
                        <td class="px-5 py-2"><p class="font-medium">{{ $sch->sessionCourse?->course?->name }}</p><p class="text-xs text-gray-400">{{ $sch->sessionCourse?->course?->code }}</p></td>
                        <td class="px-5 py-2 text-gray-500">{{ $sch->start_time }} – {{ $sch->end_time }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $sch->room?->name ?? '—' }}</td>
                        <td class="px-5 py-2"><span class="px-2 py-0.5 rounded-full text-xs {{ $sch->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $sch->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-5 py-2 text-right flex items-center justify-end gap-1">
                            @if(!$sch->is_published)
                            @access('exam-schedules.publish')
                            <form method="POST" action="{{ route('exam-schedules.publish', $sch) }}">@csrf
                                <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Publish</button>
                            </form>
                            @endaccess
                            @endif
                            @access('exam-schedules.destroy')
                            <form method="POST" action="{{ route('exam-schedules.destroy', $sch) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                            @endaccess
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">No exam schedules yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @access('exam-schedules.store')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Add Exam Schedule</h2>
            <form method="POST" action="{{ route('exam-schedules.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Course *</label>
                    <select name="session_course_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select —</option>
                        @foreach($schedules->pluck('sessionCourse')->unique('id') as $sc)@endforeach
                        {{-- Load all current semester session courses --}}
                        @foreach(\App\Models\SessionCourse::with('course')->whereHas('semester', fn($q)=>$q->where('is_current',true))->get() as $sc)
                        <option value="{{ $sc->id }}">{{ $sc->course?->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Date *</label><input type="date" name="date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Start *</label><input type="time" name="start_time" required class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">End *</label><input type="time" name="end_time" required class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                </div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add</button>
            </form>
        </div>
        @endaccess
    </div>
</x-app-layout>
