<x-app-layout>
    <x-slot name="title">Issue / Return Books</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Issue & Return Books</h1></div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        @access('library.issue.store')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Issue Book</h3>
            <form method="POST" action="{{ route('library.issue.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Book *</label>
                    <select name="book_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Book (Available Only) —</option>
                        @foreach($books as $b)<option value="{{ $b->id }}">{{ Str::limit($b->title,50) }} — {{ $b->available }} left</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Member *</label>
                    <select name="member_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Member —</option>
                        @foreach($members as $m)<option value="{{ $m->id }}">{{ $m->member_no }} ({{ ucfirst($m->person_type) }})</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Due Date *</label><input type="date" name="due_date" required min="{{ now()->addDay()->format('Y-m-d') }}" value="{{ now()->addDays(14)->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Issue Book</button>
            </form>
        </div>
        @endaccess
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h3 class="font-semibold text-gray-900">Recent Issues</h3></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b"><tr><th class="text-left px-4 py-2 font-medium text-gray-600">Book</th><th class="text-left px-4 py-2 font-medium text-gray-600">Member</th><th class="text-left px-4 py-2 font-medium text-gray-600">Due</th><th class="text-left px-4 py-2 font-medium text-gray-600">Status</th><th class="text-right px-4 py-2 font-medium text-gray-600">Action</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentIssues as $issue)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-xs text-gray-700">{{ Str::limit($issue->book?->title,30) }}</td>
                        <td class="px-4 py-2 text-xs font-mono text-blue-600">{{ $issue->member?->member_no }}</td>
                        <td class="px-4 py-2 text-xs {{ $issue->due_date?->isPast() && $issue->status==='issued' ? 'text-red-600 font-medium' : 'text-gray-500' }}">{{ $issue->due_date?->format('d M Y') }}</td>
                        <td class="px-4 py-2"><span class="px-1.5 py-0.5 rounded-full text-xs {{ $issue->status==='issued'?'bg-blue-100 text-blue-700':($issue->status==='returned'?'bg-green-100 text-green-700':'bg-red-100 text-red-700') }}">{{ ucfirst($issue->status) }}</span></td>
                        <td class="px-4 py-2 text-right">
                            @if($issue->status==='issued')
                            @access('library.return')
                            <form method="POST" action="{{ route('library.return', $issue) }}">@csrf
                                <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Return</button>
                            </form>
                            @endaccess
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">No issues yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
