<x-app-layout>
    <x-slot name="title">Issue Book</x-slot>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Issue Book</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Issue a Book</h3>
            <form method="POST" action="{{ route('library.issue') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Book *</label>
                    <select name="book_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select available book</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->available }} available)</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Member *</label>
                    <select name="member_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select member</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->member_no }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Issue Book</button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="font-semibold text-gray-900 text-sm">Recently Issued</p>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Book</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Member</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Issue Date</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Due Date</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recent as $issue)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ Str::limit($issue->book->title, 30) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $issue->member->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $issue->issue_date->format('d M Y') }}</td>
                        <td class="px-4 py-3 {{ $issue->due_date->isPast() ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                            {{ $issue->due_date->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $issue->status === 'issued' ? 'bg-blue-50 text-blue-700' : ($issue->status === 'overdue' ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700') }}">
                                {{ ucfirst($issue->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">No recent issues.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
