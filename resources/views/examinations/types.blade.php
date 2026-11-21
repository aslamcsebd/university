<x-app-layout>
    <x-slot name="title">Exam Types</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Exam Types</h1><p class="text-sm text-gray-500 mt-1">Configure exam types for {{ $semester?->name ?? 'current semester' }}</p></div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Exam Types</h2></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Name</th><th class="text-left px-5 py-2 font-medium text-gray-600">Semester</th><th class="text-right px-5 py-2 font-medium text-gray-600">Actions</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($examTypes as $et)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 font-medium text-gray-900">{{ $et->name }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $et->semester?->name ?? 'All' }}</td>
                        <td class="px-5 py-2 text-right">
                            @access('exam-types.destroy')
                            <form method="POST" action="{{ route('exam-types.destroy', $et) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                            @endaccess
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-6 text-center text-gray-400">No exam types.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @access('exam-types.store')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Add Exam Type</h2>
            <form method="POST" action="{{ route('exam-types.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Midterm, Final, Quiz" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <select name="semester_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Semesters</option>
                        @foreach($semesters as $s)<option value="{{ $s->id }}" {{ old('semester_id')==$s->id || $semester?->id==$s->id ? 'selected':'' }}>{{ $s->name }}</option>@endforeach
                    </select>
                </div>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Exam Type</button>
            </form>
        </div>
        @endaccess
    </div>
</x-app-layout>
