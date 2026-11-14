<x-app-layout>
    <x-slot name="title">Issue & Return</x-slot>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Issue & Return</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <form method="GET" class="flex gap-3 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by member name or number..."
               class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Search</button>
    </form>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Book</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Member</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Issue Date</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Due Date</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($issues as $issue)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ Str::limit($issue->book->title, 35) }}</td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-900">{{ $issue->member->name }}</div>
                        <div class="text-xs text-gray-400">{{ $issue->member->member_no }}</div>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $issue->issue_date->format('d M Y') }}</td>
                    <td class="px-4 py-3 {{ $issue->due_date->isPast() ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                        {{ $issue->due_date->format('d M Y') }}
                        @if($issue->due_date->isPast())
                            <div class="text-xs">{{ $issue->due_date->diffInDays(today()) }} days overdue</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $issue->status === 'issued' ? 'bg-blue-50 text-blue-700' : 'bg-red-50 text-red-700' }}">
                            {{ ucfirst($issue->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="{{ route('library.return', $issue) }}" onsubmit="return confirm('Process return?')">
                            @csrf
                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded text-xs font-medium hover:bg-green-700">
                                Return
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No active issues found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $issues->links() }}</div>
    </div>
</x-app-layout>
