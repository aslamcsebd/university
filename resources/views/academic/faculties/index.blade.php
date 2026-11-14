<x-app-layout>
    <x-slot name="title">Faculties</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Faculties</h1>
            <p class="text-sm text-gray-500 mt-1">Manage university faculties</p>
        </div>
        <a href="{{ route('faculties.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Faculty
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search faculties..."
                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Search</button>
            @if(request('search'))<a href="{{ route('faculties.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Clear</a>@endif
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">#</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Name</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Short Name</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Code</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Departments</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Programs</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($faculties as $i => $faculty)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-gray-400">{{ $faculties->firstItem() + $i }}</td>
                    <td class="px-5 py-3 font-medium text-gray-900">{{ $faculty->name }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $faculty->short_name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $faculty->code ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $faculty->departments_count }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $faculty->programs_count }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $faculty->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $faculty->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('faculties.edit', $faculty) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('faculties.destroy', $faculty) }}" onsubmit="return confirm('Delete this faculty?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-12 text-center text-gray-400">No faculties yet. <a href="{{ route('faculties.create') }}" class="text-blue-600">Add one →</a></td></tr>
                @endforelse
            </tbody>
        </table>
        @if($faculties->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $faculties->links() }}</div>@endif
    </div>
</x-app-layout>
