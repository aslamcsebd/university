<x-app-layout>
    <x-slot name="title">Designations</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Designations</h1><p class="text-sm text-gray-500 mt-1">Manage staff designations / job titles</p></div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- List --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">All Designations</h2></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">#</th><th class="text-left px-5 py-2 font-medium text-gray-600">Name</th><th class="text-left px-5 py-2 font-medium text-gray-600">Staff</th><th class="text-right px-5 py-2 font-medium text-gray-600">Actions</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($designations as $i => $d)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 text-gray-400">{{ $designations->firstItem() + $i }}</td>
                        <td class="px-5 py-2 font-medium text-gray-900">{{ $d->name }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $d->staff_count }}</td>
                        <td class="px-5 py-2 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button onclick="document.getElementById('edit-{{ $d->id }}').classList.toggle('hidden')" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                <form method="POST" action="{{ route('designations.destroy', $d) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                            </div>
                            <form id="edit-{{ $d->id }}" method="POST" action="{{ route('designations.update', $d) }}" class="hidden mt-2 flex gap-2">@csrf @method('PUT')
                                <input type="text" name="name" value="{{ $d->name }}" required class="flex-1 border border-gray-300 rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs">Save</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-gray-400">No designations yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($designations->hasPages())<div class="px-5 py-3 border-t">{{ $designations->links() }}</div>@endif
        </div>
        {{-- Add Form --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Add Designation</h2>
            <form method="POST" action="{{ route('designations.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Designation Name <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Professor, Lecturer, Admin Officer" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Description</label><textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea></div>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Designation</button>
            </form>
        </div>
    </div>
</x-app-layout>
