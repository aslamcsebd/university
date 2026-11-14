<x-app-layout>
    <x-slot name="title">Edit Grading System</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('grading.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <div><h1 class="text-2xl font-bold text-gray-900">{{ $grading->name }}</h1><p class="text-sm text-gray-500">Max GPA: {{ $grading->max_gpa }}</p></div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Grade Rules Table --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Grade Rules</h2>
                <span class="text-xs text-gray-400">{{ $grading->gradeRules->count() }} rules</span>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-4 py-2 font-medium text-gray-600">Grade</th><th class="text-left px-4 py-2 font-medium text-gray-600">Min%</th><th class="text-left px-4 py-2 font-medium text-gray-600">Max%</th><th class="text-left px-4 py-2 font-medium text-gray-600">GPA</th><th class="text-left px-4 py-2 font-medium text-gray-600">Pass</th><th class="text-right px-4 py-2 font-medium text-gray-600">Del</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($grading->gradeRules as $rule)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-bold text-blue-700">{{ $rule->letter_grade }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $rule->min_percentage }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $rule->max_percentage }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $rule->gpa_point }}</td>
                        <td class="px-4 py-2">{{ $rule->is_pass ? '✅' : '❌' }}</td>
                        <td class="px-4 py-2 text-right">
                            <form method="POST" action="{{ route('grading.rules.destroy', [$grading, $rule]) }}" onsubmit="return confirm('Remove?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">No rules yet. Add rules →</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Add Rule Form --}}
        <div class="space-y-5">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-900 mb-4">Add Grade Rule</h2>
                <form method="POST" action="{{ route('grading.rules.store', $grading) }}" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Letter Grade *</label><input type="text" name="letter_grade" value="{{ old('letter_grade') }}" required maxlength="5" placeholder="A+, A, B+..." class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">GPA Point *</label><input type="number" name="gpa_point" value="{{ old('gpa_point') }}" required min="0" max="5" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Min % *</label><input type="number" name="min_percentage" value="{{ old('min_percentage') }}" required min="0" max="100" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Max % *</label><input type="number" name="max_percentage" value="{{ old('max_percentage') }}" required min="0" max="100" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    </div>
                    <div class="flex items-center gap-2"><input type="checkbox" name="is_pass" value="1" checked class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Passing Grade</label></div>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Rule</button>
                </form>
            </div>
            {{-- Quick seed default scale --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <p class="text-sm font-medium text-blue-800 mb-2">Quick Seed — Standard 4.0 Scale</p>
                <form method="POST" action="{{ route('grading.seed', $grading) }}">@csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Auto-fill Standard Scale</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
