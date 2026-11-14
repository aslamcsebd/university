<x-app-layout>
    <x-slot name="title">Programs</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Programs</h1><p class="text-sm text-gray-500 mt-1">Manage degree programs</p></div>
        <a href="{{ route('programs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Program
        </a>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search programs..." class="flex-1 min-w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="department" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Departments</option>
                @foreach($departments as $d)<option value="{{ $d->id }}" {{ request('department') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>@endforeach
            </select>
            <select name="level" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Levels</option>
                @foreach($levels as $l)<option value="{{ $l }}" {{ request('level') == $l ? 'selected' : '' }}>{{ ucfirst($l) }}</option>@endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
            @if(request()->hasAny(['search','department','level']))<a href="{{ route('programs.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Clear</a>@endif
        </form>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">#</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Program</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Department</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Level</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Duration</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Credits</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($programs as $i => $program)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-gray-400">{{ $programs->firstItem() + $i }}</td>
                    <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ $program->name }}</p><p class="text-xs text-gray-400">{{ $program->short_name }}</p></td>
                    <td class="px-5 py-3 text-gray-500">{{ $program->department?->name ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @php $lc=['bachelor'=>'bg-blue-100 text-blue-700','master'=>'bg-purple-100 text-purple-700','phd'=>'bg-red-100 text-red-700','diploma'=>'bg-yellow-100 text-yellow-700','certificate'=>'bg-green-100 text-green-700','other'=>'bg-gray-100 text-gray-600']; @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $lc[$program->level] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($program->level) }}</span>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $program->duration_years }} yrs</td>
                    <td class="px-5 py-3 text-gray-500">{{ $program->total_credits ?? '—' }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $program->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $program->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('programs.edit', $program) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                            <form method="POST" action="{{ route('programs.destroy', $program) }}" onsubmit="return confirm('Delete this program?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-12 text-center text-gray-400">No programs yet. <a href="{{ route('programs.create') }}" class="text-blue-600">Add one →</a></td></tr>
                @endforelse
            </tbody>
        </table>
        @if($programs->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $programs->links() }}</div>@endif
    </div>
</x-app-layout>
