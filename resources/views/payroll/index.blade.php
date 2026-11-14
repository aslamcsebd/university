<x-app-layout>
    <x-slot name="title">Payroll</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Payroll Management</h1><p class="text-sm text-gray-500 mt-1">Generate and manage monthly payrolls</p></div>
    </div>

    {{-- Generate Form --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
        <h3 class="font-semibold text-gray-900 mb-3">Generate Payroll</h3>
        <form method="POST" action="{{ route('payroll.generate') }}" class="flex flex-wrap gap-3 items-end">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                <select name="month" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($months as $m)<option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select name="year" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($years as $y)<option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>@endforeach
                </select>
            </div>
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700" onclick="return confirm('Generate payrolls for all active staff?')">
                Generate Payrolls
            </button>
        </form>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="month" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($months as $m)<option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>@endforeach
            </select>
            <select name="year" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($years as $y)<option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>@endforeach
            </select>
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="draft" {{ request('status')=='draft'?'selected':'' }}>Draft</option>
                <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
                <option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">View</button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">{{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }} — Payroll</h2>
            <span class="text-sm text-gray-500">{{ $payrolls->total() }} records</span>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Staff</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Department</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Basic</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Gross</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Tax</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Net</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($payrolls as $payroll)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-900">{{ $payroll->staff?->full_name }}</p>
                        <p class="text-xs text-gray-400">{{ $payroll->staff?->employee_id }}</p>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $payroll->staff?->department?->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ number_format($payroll->basic, 2) }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ number_format($payroll->gross, 2) }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ number_format($payroll->tax, 2) }}</td>
                    <td class="px-5 py-3 font-semibold text-gray-900">{{ number_format($payroll->net_salary, 2) }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $payroll->status_color }}">{{ ucfirst($payroll->status) }}</span></td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            @if($payroll->status === 'draft')
                                <form method="POST" action="{{ route('payroll.approve', $payroll) }}">@csrf
                                    <button type="submit" class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('payroll.destroy', $payroll) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                    <button type="submit" class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </form>
                            @elseif($payroll->status === 'approved')
                                <form method="POST" action="{{ route('payroll.paid', $payroll) }}">@csrf
                                    <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Mark Paid</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">{{ $payroll->paid_at?->format('d M Y') }}</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-12 text-center text-gray-400">No payrolls for this period. Click "Generate Payrolls" above.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($payrolls->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $payrolls->links() }}</div>@endif
    </div>
</x-app-layout>
