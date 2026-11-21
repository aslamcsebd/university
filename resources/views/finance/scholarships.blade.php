<x-app-layout>
    <x-slot name="title">Scholarships</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Scholarships</h1><p class="text-sm text-gray-500 mt-1">Manage scholarship programs</p></div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">All Scholarships</h2>
                @access('scholarships.applications')
                <a href="{{ route('scholarships.applications') }}" class="text-xs text-blue-600 hover:underline">View Applications →</a>
                @endaccess
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Name</th><th class="text-left px-5 py-2 font-medium text-gray-600">Type</th><th class="text-left px-5 py-2 font-medium text-gray-600">Value</th><th class="text-left px-5 py-2 font-medium text-gray-600">Apps</th><th class="text-right px-5 py-2 font-medium text-gray-600">Del</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($scholarships as $s)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 font-medium text-gray-900">{{ $s->name }}</td>
                        <td class="px-5 py-2"><span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full text-xs">{{ ucfirst(str_replace('_',' ',$s->type)) }}</span></td>
                        <td class="px-5 py-2 text-gray-700">{{ $s->value_type=='percentage' ? $s->value.'%' : number_format($s->value,2) }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $s->applications_count }}</td>
                        <td class="px-5 py-2 text-right">
                            @access('scholarships.destroy')
                            <form method="POST" action="{{ route('scholarships.destroy', $s) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                            @endaccess
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">No scholarships yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @access('scholarships.store')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Create Scholarship</h2>
            <form method="POST" action="{{ route('scholarships.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Name *</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Type *</label>
                        <select name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="merit">Merit</option>
                            <option value="need_based">Need Based</option>
                            <option value="sports">Sports</option>
                            <option value="disability">Disability</option>
                            <option value="staff_dependent">Staff Dependent</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Value Type *</label>
                        <select name="value_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Value *</label><input type="number" name="value" required min="0" step="0.01" placeholder="e.g. 50 for 50% or 5000 for fixed" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Start Date</label><input type="date" name="application_start" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">End Date</label><input type="date" name="application_end" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                </div>
                <div class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Active</label></div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Create Scholarship</button>
            </form>
        </div>
        @endaccess
    </div>
</x-app-layout>
