<x-app-layout>
    <x-slot name="title">Admission Status Types</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admissions.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <h1 class="text-2xl font-bold text-gray-900">Admission Status Types</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Status List</h2></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Order</th><th class="text-left px-5 py-2 font-medium text-gray-600">Name</th><th class="text-left px-5 py-2 font-medium text-gray-600">Approval</th><th class="text-left px-5 py-2 font-medium text-gray-600">Apps</th><th class="text-right px-5 py-2 font-medium text-gray-600">Actions</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($statuses as $st)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 text-gray-400">{{ $st->order }}</td>
                        <td class="px-5 py-2"><span class="px-2 py-0.5 rounded-full text-xs text-white" style="background-color: {{ $st->color }}">{{ $st->name }}</span></td>
                        <td class="px-5 py-2">{{ $st->is_approval_trigger ? '✅ Yes' : '—' }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $st->applications_count }}</td>
                        <td class="px-5 py-2 text-right">
                            <form method="POST" action="{{ route('admission.statuses.destroy', $st) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">No statuses. Add one →</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Add Status Type</h2>
            <form method="POST" action="{{ route('admission.statuses.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Pending, Approved, Rejected" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Color</label><input type="color" name="color" value="{{ old('color', '#6b7280') }}" class="w-full h-10 border border-gray-300 rounded-lg px-2 cursor-pointer"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label><input type="number" name="order" value="{{ old('order', 0) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div class="flex items-center gap-2"><input type="checkbox" name="is_approval_trigger" value="1" {{ old('is_approval_trigger') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Approval Trigger (converts to student)</label></div>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Status</button>
            </form>
        </div>
    </div>
</x-app-layout>
