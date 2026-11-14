<x-app-layout>
    <x-slot name="title">Scholarship Applications</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('scholarships.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <h1 class="text-2xl font-bold text-gray-900">Scholarship Applications</h1>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
                <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
            </select>
            <select name="scholarship" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Scholarships</option>
                @foreach($scholarships as $s)<option value="{{ $s->id }}" {{ request('scholarship')==$s->id?'selected':'' }}>{{ $s->name }}</option>@endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
        </form>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Student</th><th class="text-left px-5 py-3 font-medium text-gray-600">Scholarship</th><th class="text-left px-5 py-3 font-medium text-gray-600">Semester</th><th class="text-left px-5 py-3 font-medium text-gray-600">Status</th><th class="text-left px-5 py-3 font-medium text-gray-600">Applied</th><th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($applications as $app)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ $app->student?->full_name }}</p><p class="text-xs font-mono text-purple-600">{{ $app->student?->student_id }}</p></td>
                    <td class="px-5 py-3 text-gray-500">{{ $app->scholarship?->name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $app->semester?->name ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @php $sc=['pending'=>'bg-yellow-100 text-yellow-700','approved'=>'bg-green-100 text-green-700','rejected'=>'bg-red-100 text-red-700','revoked'=>'bg-gray-100 text-gray-600']; @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $sc[$app->status]??'' }}">{{ ucfirst($app->status) }}</span>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $app->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        @if($app->status === 'pending')
                        <div class="flex items-center justify-end gap-1">
                            <form method="POST" action="{{ route('scholarships.approve', $app) }}">@csrf
                                <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('scholarships.reject', $app) }}">@csrf
                                <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">Reject</button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400">No applications found.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($applications->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $applications->links() }}</div>@endif
    </div>
</x-app-layout>
