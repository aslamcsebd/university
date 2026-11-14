<x-app-layout>
    <x-slot name="title">Leave Management</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Leave Management</h1><p class="text-sm text-gray-500 mt-1">Review and manage staff leave applications</p></div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
                <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
            </select>
            <select name="leave_type" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Leave Types</option>
                @foreach($leaveTypes as $lt)<option value="{{ $lt->id }}" {{ request('leave_type')==$lt->id?'selected':'' }}>{{ $lt->name }}</option>@endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
            @if(request()->hasAny(['status','leave_type']))<a href="{{ route('staff-leave.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Clear</a>@endif
        </form>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Applicant</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Leave Type</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">From</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">To</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Days</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($applications as $app)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium text-gray-900">{{ $app->applicant?->name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $app->leaveType?->name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $app->from_date->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $app->to_date->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $app->days_count }}</td>
                    <td class="px-5 py-3">
                        @php $sc=['pending'=>'bg-yellow-100 text-yellow-700','approved'=>'bg-green-100 text-green-700','rejected'=>'bg-red-100 text-red-700']; @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $sc[$app->status] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($app->status) }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        @if($app->status === 'pending')
                        <div class="flex items-center justify-end gap-1">
                            <form method="POST" action="{{ route('staff-leave.approve', $app) }}">@csrf
                                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded-lg text-xs hover:bg-green-700">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('staff-leave.reject', $app) }}">@csrf
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs hover:bg-red-700">Reject</button>
                            </form>
                        </div>
                        @else
                        <span class="text-xs text-gray-400">{{ $app->reviewed_at?->format('d M Y') }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-12 text-center text-gray-400">No leave applications found.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($applications->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $applications->links() }}</div>@endif
    </div>
</x-app-layout>
