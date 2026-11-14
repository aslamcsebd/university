<x-app-layout>
    <x-slot name="title">Mark Entry</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Mark Entry</h1><p class="text-sm text-gray-500 mt-1">Enter student marks for exam types</p></div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
        {{-- Selector --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Select Course & Exam</h3>
            <form method="GET" class="space-y-3">
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Course</label>
                    <select name="session_course_id" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select —</option>
                        @foreach($sessionCourses as $sc)<option value="{{ $sc->id }}" {{ $selectedCourse?->id==$sc->id?'selected':'' }}>{{ $sc->course?->name }}</option>@endforeach
                    </select>
                </div>
                @if($selectedCourse)
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Exam Type</label>
                    <select name="distribution_id" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select —</option>
                        @foreach($distributions as $d)<option value="{{ $d->id }}" {{ $selectedDistribution?->id==$d->id?'selected':'' }}>{{ $d->examType?->name }} ({{ $d->total_marks }} marks)</option>@endforeach
                    </select>
                </div>
                @endif
            </form>
        </div>

        {{-- Mark Entry Table --}}
        <div class="lg:col-span-3">
            @if($selectedDistribution && $students->count())
            <form method="POST" action="{{ route('marks.save') }}" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                @csrf
                <input type="hidden" name="distribution_id" value="{{ $selectedDistribution->id }}">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">{{ $selectedCourse?->course?->name }} — {{ $selectedDistribution->examType?->name }}</h3>
                    <span class="text-xs text-gray-500">Total: {{ $selectedDistribution->total_marks }} | Pass: {{ $selectedDistribution->pass_marks ?? 'N/A' }}</span>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Student</th><th class="text-left px-5 py-2 font-medium text-gray-600">Student ID</th><th class="text-left px-5 py-2 font-medium text-gray-600">Marks (/ {{ $selectedDistribution->total_marks }})</th><th class="text-left px-5 py-2 font-medium text-gray-600">Absent</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($students as $s)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-2 font-medium text-gray-900">{{ $s['name'] }}</td>
                            <td class="px-5 py-2 font-mono text-xs text-purple-600">{{ $s['sid'] }}</td>
                            <td class="px-5 py-2"><input type="number" name="marks[{{ $s['id'] }}][marks]" value="{{ $s['marks'] }}" min="0" max="{{ $selectedDistribution->total_marks }}" step="0.5" class="w-24 border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></td>
                            <td class="px-5 py-2"><input type="checkbox" name="marks[{{ $s['id'] }}][is_absent]" value="1" {{ $s['is_absent'] ? 'checked' : '' }} class="rounded border-gray-300 text-red-600"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-5 py-4 border-t border-gray-100">
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Save Marks</button>
                </div>
            </form>
            @else
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-400">
                @if(!$selectedCourse) Select a course to begin mark entry.
                @elseif(!$selectedDistribution) Select an exam type to load students.
                @else No students enrolled.
                @endif
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
