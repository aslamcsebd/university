<x-app-layout>
    <x-slot name="title">Results</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Result Management</h1><p class="text-sm text-gray-500 mt-1">Process and publish semester results</p></div>
    </div>

    {{-- Process & Publish Actions --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
        <h3 class="font-semibold text-gray-900 mb-3">Actions</h3>
        <div class="flex flex-wrap gap-3">
            @access('results.process')
            <form method="POST" action="{{ route('results.process') }}" class="flex gap-2">
                @csrf
                <select name="semester_id" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Select Semester —</option>
                    @foreach($semesters as $s)<option value="{{ $s->id }}" {{ $semester?->id==$s->id?'selected':'' }}>{{ $s->name }} ({{ $s->academicSession?->name }}) {{ $s->is_current?'★ Current':'' }}</option>@endforeach
                </select>
                <button type="submit" onclick="return confirm('Process results for selected semester?')" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Process Results</button>
            </form>
            @endaccess
            @access('results.publish')
            <form method="POST" action="{{ route('results.publish') }}" class="flex gap-2">
                @csrf
                <select name="semester_id" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Select Semester —</option>
                    @foreach($semesters as $s)<option value="{{ $s->id }}" {{ $semester?->id==$s->id?'selected':'' }}>{{ $s->name }}</option>@endforeach
                </select>
                <button type="submit" onclick="return confirm('Publish all results? Students will be able to see them.')" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700">Publish Results</button>
            </form>
            @endaccess
        </div>
    </div>

    {{-- Results Table --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Results {{ $semester ? '— '.$semester->name : '' }}</h2>
            <span class="text-sm text-gray-400">{{ $results->total() }} records</span>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Student</th><th class="text-left px-5 py-3 font-medium text-gray-600">Course</th><th class="text-left px-5 py-3 font-medium text-gray-600">Marks</th><th class="text-left px-5 py-3 font-medium text-gray-600">%</th><th class="text-left px-5 py-3 font-medium text-gray-600">Grade</th><th class="text-left px-5 py-3 font-medium text-gray-600">GPA</th><th class="text-left px-5 py-3 font-medium text-gray-600">Pass</th><th class="text-left px-5 py-3 font-medium text-gray-600">Status</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($results as $result)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ $result->student?->full_name }}</p><p class="text-xs font-mono text-purple-600">{{ $result->student?->student_id }}</p></td>
                    <td class="px-5 py-3 text-gray-500">{{ $result->sessionCourse?->course?->name }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $result->obtained_marks }} / {{ $result->total_marks }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ number_format($result->percentage, 1) }}%</td>
                    <td class="px-5 py-3 font-bold text-blue-700">{{ $result->letter_grade ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $result->gpa_point }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $result->is_pass ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $result->is_pass ? 'Pass' : 'Fail' }}</span></td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $result->is_published ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $result->is_published ? 'Published' : 'Draft' }}</span></td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-12 text-center text-gray-400">No results yet. Select a semester and click "Process Results".</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($results->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $results->links() }}</div>@endif
    </div>
</x-app-layout>
