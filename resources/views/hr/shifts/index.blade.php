<x-app-layout>
    <x-slot name="title">Work Shifts</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Work Shifts</h1><p class="text-sm text-gray-500 mt-1">Configure staff working shifts</p></div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">All Shifts</h2></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Name</th><th class="text-left px-5 py-2 font-medium text-gray-600">Start</th><th class="text-left px-5 py-2 font-medium text-gray-600">End</th><th class="text-left px-5 py-2 font-medium text-gray-600">Grace</th><th class="text-left px-5 py-2 font-medium text-gray-600">Staff</th><th class="text-right px-5 py-2 font-medium text-gray-600">Actions</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($shifts as $shift)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 font-medium text-gray-900">{{ $shift->name }}</td>
                        <td class="px-5 py-2 text-gray-600">{{ $shift->start_time }}</td>
                        <td class="px-5 py-2 text-gray-600">{{ $shift->end_time }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $shift->grace_minutes }} min</td>
                        <td class="px-5 py-2 text-gray-500">{{ $shift->staff_count }}</td>
                        <td class="px-5 py-2 text-right">
                            @access('shifts.destroy')
                            <form method="POST" action="{{ route('shifts.destroy', $shift) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                            @endaccess
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-gray-400">No shifts yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @access('shifts.store')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Add Work Shift</h2>
            <form method="POST" action="{{ route('shifts.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Shift Name <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Morning, Evening" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Start Time <span class="text-red-500">*</span></label><input type="time" name="start_time" value="{{ old('start_time') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('start_time')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">End Time <span class="text-red-500">*</span></label><input type="time" name="end_time" value="{{ old('end_time') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('end_time')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Grace Minutes</label><input type="number" name="grace_minutes" value="{{ old('grace_minutes', 10) }}" min="0" max="60" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><p class="text-xs text-gray-400 mt-1">Minutes of late arrival allowed before marking as late</p></div>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Shift</button>
            </form>
        </div>
        @endaccess
    </div>
</x-app-layout>
