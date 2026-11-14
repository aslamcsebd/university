<x-app-layout>
    <x-slot name="title">Mark Distribution</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Mark Distribution</h1><p class="text-sm text-gray-500 mt-1">Set marks and weightage per course per exam type</p></div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Current Distributions</h2></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Course</th><th class="text-left px-5 py-2 font-medium text-gray-600">Exam Type</th><th class="text-left px-5 py-2 font-medium text-gray-600">Total</th><th class="text-left px-5 py-2 font-medium text-gray-600">Pass</th><th class="text-left px-5 py-2 font-medium text-gray-600">Weight%</th><th class="text-right px-5 py-2 font-medium text-gray-600">Del</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($distributions as $dist)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 font-medium text-gray-900">{{ $dist->sessionCourse?->course?->name }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $dist->examType?->name }}</td>
                        <td class="px-5 py-2 text-gray-700">{{ $dist->total_marks }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $dist->pass_marks ?? '—' }}</td>
                        <td class="px-5 py-2 text-gray-700">{{ $dist->weightage }}%</td>
                        <td class="px-5 py-2 text-right">
                            <form method="POST" action="{{ route('mark-distributions.destroy', $dist) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-gray-400">No distributions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Add Distribution</h2>
            <form method="POST" action="{{ route('mark-distributions.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Course *</label>
                    <select name="session_course_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">—</option>
                        @foreach($sessionCourses as $sc)<option value="{{ $sc->id }}">{{ $sc->course?->name }}</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Exam Type *</label>
                    <select name="exam_type_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">—</option>
                        @foreach($examTypes as $et)<option value="{{ $et->id }}">{{ $et->name }}</option>@endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Total Marks *</label><input type="number" name="total_marks" required min="1" step="0.5" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Pass Marks</label><input type="number" name="pass_marks" min="0" step="0.5" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Weightage % *</label><input type="number" name="weightage" required min="0.01" max="100" step="0.01" placeholder="e.g. 30 for 30%" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Save</button>
            </form>
        </div>
    </div>
</x-app-layout>
