<x-app-layout>
    <x-slot name="title">Payments</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Payments</h1><p class="text-sm text-gray-500 mt-1">Today's collection: <span class="text-green-600 font-semibold">{{ number_format($totalToday,2) }}</span></p></div>
        <a href="{{ route('payments.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Collect Payment
        </a>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search student..." class="flex-1 min-w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="method" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Methods</option>
                <option value="cash" {{ request('method')=='cash'?'selected':'' }}>Cash</option>
                <option value="bank_transfer" {{ request('method')=='bank_transfer'?'selected':'' }}>Bank Transfer</option>
                <option value="online" {{ request('method')=='online'?'selected':'' }}>Online</option>
                <option value="cheque" {{ request('method')=='cheque'?'selected':'' }}>Cheque</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
        </form>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Receipt</th><th class="text-left px-5 py-3 font-medium text-gray-600">Student</th><th class="text-left px-5 py-3 font-medium text-gray-600">Fee Type</th><th class="text-left px-5 py-3 font-medium text-gray-600">Amount</th><th class="text-left px-5 py-3 font-medium text-gray-600">Method</th><th class="text-left px-5 py-3 font-medium text-gray-600">Date</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($payments as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-mono text-xs text-blue-600">{{ $p->receipt_no }}</td>
                    <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ $p->student?->full_name }}</p><p class="text-xs font-mono text-purple-600">{{ $p->student?->student_id }}</p></td>
                    <td class="px-5 py-3 text-gray-500">{{ $p->feeAssignment?->feeType?->name }}</td>
                    <td class="px-5 py-3 font-semibold text-gray-900">{{ number_format($p->amount,2) }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">{{ ucfirst(str_replace('_',' ',$p->payment_method)) }}</span></td>
                    <td class="px-5 py-3 text-gray-500">{{ $p->paid_at?->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400">No payments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($payments->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $payments->links() }}</div>@endif
    </div>
</x-app-layout>
