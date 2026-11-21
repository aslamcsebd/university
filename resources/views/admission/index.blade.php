<x-app-layout>
    <x-slot name="title">Admission Applications</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Admission Applications</h1><p class="text-sm text-gray-500 mt-1">Manage all admission applications</p></div>
        <div class="flex gap-2">
            @access('admission.statuses.index')
            <a href="{{ route('admission.statuses.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Status Types</a>
            @endaccess
            @access('admissions.create')
            <a href="{{ route('admissions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> New Application
            </a>
            @endaccess
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">
        @foreach($statuses as $st)
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-2xl font-bold text-gray-900">{{ $st->applications_count ?? $applications->where('status_id', $st->id)->count() }}</p>
            <p class="text-xs mt-1" style="color: {{ $st->color }}">● {{ $st->name }}</p>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..." class="flex-1 min-w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                @foreach($statuses as $st)<option value="{{ $st->id }}" {{ request('status') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>@endforeach
            </select>
            <select name="program" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Programs</option>
                @foreach($programs as $p)<option value="{{ $p->id }}" {{ request('program') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
            @if(request()->hasAny(['search','status','program','session']))@access('admissions.index')
<a href="{{ route('admissions.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Clear</a>
            @endaccess
@endif
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">#</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Applicant</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Program</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Session</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Applied</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($applications as $i => $app)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-gray-400">{{ $applications->firstItem() + $i }}</td>
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-900">{{ $app->applicant_name }}</p>
                        <p class="text-xs text-gray-400">{{ $app->email }}</p>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $app->program?->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $app->academicSession?->name ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @if($app->status)
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: {{ $app->status->color }}">{{ $app->status->name }}</span>
                        @else<span class="text-gray-400 text-xs">—</span>@endif
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $app->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            @access('admissions.show')
                            <a href="{{ route('admissions.show', $app) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                            @endaccess
                            @access('admissions.destroy')
                            <form method="POST" action="{{ route('admissions.destroy', $app) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                            @endaccess
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-12 text-center text-gray-400">No applications yet. @access('admissions.create')
<a href="{{ route('admissions.create') }}" class="text-blue-600">Create one →</a>
@endaccess</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($applications->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $applications->links() }}</div>@endif
    </div>
</x-app-layout>
