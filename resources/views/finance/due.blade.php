<x-app-layout>
    <x-slot name="title">Overdue Fees</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Overdue Fees</h1><p class="text-sm text-gray-500 mt-1">Pending fees past their due date</p></div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Student</th><th class="text-left px-5 py-3 font-medium text-gray-600">Fee Type</th><th class="text-left px-5 py-3 font-medium text-gray-600">Amount</th><th class="text-left px-5 py-3 font-medium text-gray-600">Outstanding</th><th class="text-left px-5 py-3 font-medium text-gray-600">Due Date</th><th class="text-left px-5 py-3 font-medium text-gray-600">Days Overdue</th><th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($assignments as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ $a->student?->full_name }}</p><p class="text-xs font-mono text-purple-600">{{ $a->student?->student_id }}</p></td>
                    <td class="px-5 py-3 text-gray-500">{{ $a->feeType?->name }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ number_format($a->net_amount,2) }}</td>
                    <td class="px-5 py-3 font-medium text-red-600">{{ number_format($a->outstanding,2) }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $a->due_date?->format('d M Y') }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs">{{ $a->due_date?->diffInDays(now()) }} days</span></td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('payments.create', ['assignment' => $a->id]) }}" class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">Collect</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-12 text-center text-gray-400">No overdue fees. 🎉</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($assignments->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $assignments->links() }}</div>@endif
    </div>
</x-app-layout>
