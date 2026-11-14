<x-app-layout>
    <x-slot name="title">Book Return Due</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Book Return Due</h1>
            <p class="text-sm text-gray-500 mt-1">Overdue books that need to be returned</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Book</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Member</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Due Date</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Days Overdue</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">Est. Fine</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($issues as $issue)
                @php $overdueDays = $issue->due_date->diffInDays(today()); @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ Str::limit($issue->book->title, 40) }}</td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-900">{{ $issue->member->name }}</div>
                        <div class="text-xs text-gray-400">{{ $issue->member->member_no }}</div>
                    </td>
                    <td class="px-4 py-3 text-red-600 font-semibold">{{ $issue->due_date->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 bg-red-50 text-red-700 rounded-full text-xs font-bold">{{ $overdueDays }} days</span>
                    </td>
                    <td class="px-4 py-3 text-right font-semibold text-red-600">
                        ৳{{ number_format(min($overdueDays * 5, 200), 2) }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">No overdue books. 🎉</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $issues->links() }}</div>
    </div>
</x-app-layout>
