<x-app-layout>
    <x-slot name="title">Overdue Books</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Overdue Books</h1><p class="text-sm text-gray-500 mt-1">{{ count($overdue) }} overdue issue(s)</p></div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Book</th><th class="text-left px-5 py-3 font-medium text-gray-600">Member</th><th class="text-left px-5 py-3 font-medium text-gray-600">Issue Date</th><th class="text-left px-5 py-3 font-medium text-gray-600">Due Date</th><th class="text-left px-5 py-3 font-medium text-gray-600">Days Overdue</th><th class="text-right px-5 py-3 font-medium text-gray-600">Action</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($overdue as $issue)
                <tr class="hover:bg-gray-50 bg-red-50">
                    <td class="px-5 py-3 font-medium text-gray-900">{{ Str::limit($issue->book?->title,40) }}</td>
                    <td class="px-5 py-3 font-mono text-blue-600">{{ $issue->member?->member_no }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $issue->issue_date->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-red-600 font-medium">{{ $issue->due_date->format('d M Y') }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">{{ $issue->due_date->diffInDays(now()) }} days</span></td>
                    <td class="px-5 py-3 text-right">
                        <form method="POST" action="{{ route('library.return', $issue) }}">@csrf
                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Return & Collect Fine</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400">No overdue books. 🎉</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
