<x-app-layout>
    <x-slot name="title">Staff Library Members</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Staff Library Members</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $members->total() }} members</p>
        </div>
        <button onclick="document.getElementById('add-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Member
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Member No</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Name</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Contact</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Valid Until</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Max Books</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($members as $member)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-xs font-bold text-indigo-600">{{ $member->member_no }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $member->name }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $member->email ?? $member->phone ?? '—' }}</td>
                    <td class="px-4 py-3 {{ $member->valid_until->isPast() ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                        {{ $member->valid_until->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 text-center font-bold text-gray-700">{{ $member->max_books }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $member->is_active ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            {{ $member->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="{{ route('library.members.destroy', $member) }}" onsubmit="return confirm('Remove member?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline font-medium">Remove</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">No staff members yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $members->links() }}</div>
    </div>

    <div id="add-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        @access('library.members.store')
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="font-bold text-gray-900 mb-4">Add Staff Member</h3>
            <form method="POST" action="{{ route('library.members.store') }}" class="space-y-3">
                @csrf
                <input type="hidden" name="person_type" value="staff">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Staff</label>
                    <select name="person_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select staff (optional)</option>
                        @foreach($staffList as $s)
                            <option value="{{ $s->id }}">{{ $s->first_name }} {{ $s->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Valid Until *</label>
                        <input type="date" name="valid_until" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Max Books *</label>
                        <input type="number" name="max_books" value="5" min="1" max="20" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Member</button>
                    <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
        @endaccess
    </div>
</x-app-layout>
