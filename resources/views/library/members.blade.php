<x-app-layout>
    <x-slot name="title">Library Members</x-slot>
    <div class="mb-6 flex items-center justify-between">
        <div><h1 class="text-2xl font-bold text-gray-900">Library Members</h1></div>
        @access('library.index')
        <a href="{{ route('library.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← Books</a>
        @endaccess
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Member No</th><th class="text-left px-5 py-3 font-medium text-gray-600">Type</th><th class="text-left px-5 py-3 font-medium text-gray-600">Valid Until</th><th class="text-left px-5 py-3 font-medium text-gray-600">Max Books</th><th class="text-left px-5 py-3 font-medium text-gray-600">Status</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($members as $member)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-mono text-blue-600 font-medium">{{ $member->member_no }}</td>
                        <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $member->person_type=='student'?'bg-purple-100 text-purple-700':'bg-blue-100 text-blue-700' }}">{{ ucfirst($member->person_type) }}</span></td>
                        <td class="px-5 py-3 text-gray-500">{{ $member->valid_until?->format('d M Y') ?? 'No expiry' }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $member->max_books }}</td>
                        <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $member->is_active?'bg-green-100 text-green-700':'bg-red-100 text-red-700' }}">{{ $member->is_active?'Active':'Inactive' }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">No members yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($members->hasPages())<div class="px-5 py-4 border-t">{{ $members->links() }}</div>@endif
        </div>
        @access('library.members.store')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Add Member</h3>
            <form method="POST" action="{{ route('library.members.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Type *</label>
                    <select name="person_type" required id="personType" onchange="updatePersonList()" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="student">Student</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Person *</label>
                    <select name="person_id" required id="personSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Student —</option>
                        @foreach($students as $s)<option value="{{ $s->id }}" data-type="student">{{ $s->full_name }} ({{ $s->student_id }})</option>@endforeach
                        @foreach($staff as $s)<option value="{{ $s->id }}" data-type="staff" style="display:none">{{ $s->full_name }} ({{ $s->employee_id }})</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Valid Until</label><input type="date" name="valid_until" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Max Books</label><input type="number" name="max_books" value="3" min="1" max="10" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Member</button>
            </form>
        </div>
        @endaccess
    </div>
    @push('scripts')
    <script>
    function updatePersonList() {
        const type = document.getElementById('personType').value;
        document.querySelectorAll('#personSelect option[data-type]').forEach(o => {
            o.style.display = o.dataset.type === type ? '' : 'none';
        });
        document.getElementById('personSelect').value = '';
    }
    </script>
    @endpush
</x-app-layout>
