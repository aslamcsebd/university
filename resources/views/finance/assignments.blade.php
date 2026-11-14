<x-app-layout>
    <x-slot name="title">Fee Assignments</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Fee Assignments</h1><p class="text-sm text-gray-500 mt-1">Manage student fee assignments</p></div>
        <div class="flex gap-2">
            <a href="{{ route('fee-assignments.due') }}" class="px-4 py-2 border border-red-300 text-red-600 rounded-lg text-sm hover:bg-red-50">Overdue Fees</a>
            <a href="{{ route('fee-assignments.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Assign Fee
            </a>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search student..." class="flex-1 min-w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="partial" {{ request('status')=='partial'?'selected':'' }}>Partial</option>
                <option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option>
                <option value="waived" {{ request('status')=='waived'?'selected':'' }}>Waived</option>
            </select>
            <select name="fee_type" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Fee Types</option>
                @foreach($feeTypes as $ft)<option value="{{ $ft->id }}" {{ request('fee_type')==$ft->id?'selected':'' }}>{{ $ft->name }}</option>@endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
            @if(request()->hasAny(['search','status','fee_type']))<a href="{{ route('fee-assignments.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Clear</a>@endif
        </form>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Student</th><th class="text-left px-5 py-3 font-medium text-gray-600">Fee Type</th><th class="text-left px-5 py-3 font-medium text-gray-600">Amount</th><th class="text-left px-5 py-3 font-medium text-gray-600">Net</th><th class="text-left px-5 py-3 font-medium text-gray-600">Paid</th><th class="text-left px-5 py-3 font-medium text-gray-600">Due</th><th class="text-left px-5 py-3 font-medium text-gray-600">Status</th><th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($assignments as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ $a->student?->full_name }}</p><p class="text-xs font-mono text-purple-600">{{ $a->student?->student_id }}</p></td>
                    <td class="px-5 py-3 text-gray-500">{{ $a->feeType?->name }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ number_format($a->amount,2) }}</td>
                    <td class="px-5 py-3 font-medium text-gray-900">{{ number_format($a->net_amount,2) }}</td>
                    <td class="px-5 py-3 text-green-700">{{ number_format($a->paid_amount,2) }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $a->due_date?->format('d M Y') ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @php $sc=['pending'=>'bg-yellow-100 text-yellow-700','partial'=>'bg-blue-100 text-blue-700','paid'=>'bg-green-100 text-green-700','waived'=>'bg-gray-100 text-gray-600']; @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $sc[$a->status]??'bg-gray-100 text-gray-600' }}">{{ ucfirst($a->status) }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        @if(in_array($a->status,['pending','partial']))
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('payments.create', ['assignment' => $a->id]) }}" class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">Collect</a>
                            <form method="POST" action="{{ route('fee-assignments.waive', $a) }}">@csrf
                                <button type="submit" onclick="return confirm('Waive this fee?')" class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs hover:bg-gray-200">Waive</button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-12 text-center text-gray-400">No fee assignments. <a href="{{ route('fee-assignments.create') }}" class="text-blue-600">Assign one →</a></td></tr>
                @endforelse
            </tbody>
        </table>
        @if($assignments->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $assignments->links() }}</div>@endif
    </div>
</x-app-layout>
