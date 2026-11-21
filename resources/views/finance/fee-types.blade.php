<x-app-layout>
    <x-slot name="title">Fee Types</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Fee Types</h1><p class="text-sm text-gray-500 mt-1">Configure fee categories</p></div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">All Fee Types</h2></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Name</th><th class="text-left px-5 py-2 font-medium text-gray-600">Frequency</th><th class="text-left px-5 py-2 font-medium text-gray-600">Assignments</th><th class="text-left px-5 py-2 font-medium text-gray-600">Status</th><th class="text-right px-5 py-2 font-medium text-gray-600">Actions</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($feeTypes as $ft)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 font-medium text-gray-900">{{ $ft->name }}</td>
                        <td class="px-5 py-2"><span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">{{ ucfirst(str_replace('_',' ',$ft->frequency)) }}</span></td>
                        <td class="px-5 py-2 text-gray-500">{{ $ft->assignments_count }}</td>
                        <td class="px-5 py-2"><span class="px-2 py-0.5 rounded-full text-xs {{ $ft->is_active?'bg-green-100 text-green-700':'bg-red-100 text-red-700' }}">{{ $ft->is_active?'Active':'Inactive' }}</span></td>
                        <td class="px-5 py-2 text-right">
                            @access('fee-types.destroy')
                            <form method="POST" action="{{ route('fee-types.destroy', $ft) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                            @endaccess
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400">No fee types yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @access('fee-types.store')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Add Fee Type</h2>
            <form method="POST" action="{{ route('fee-types.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Tuition Fee, Lab Fee" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Frequency <span class="text-red-500">*</span></label>
                    <select name="frequency" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="one_time">One Time</option>
                        <option value="semester" selected>Per Semester</option>
                        <option value="monthly">Monthly</option>
                        <option value="annual">Annual</option>
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Description</label><textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea></div>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Fee Type</button>
            </form>
        </div>
        @endaccess
    </div>
</x-app-layout>
