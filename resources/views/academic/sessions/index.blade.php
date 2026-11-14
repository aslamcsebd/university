<x-app-layout>
    <x-slot name="title">Academic Sessions</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Academic Sessions</h1><p class="text-sm text-gray-500 mt-1">Manage academic years and semesters</p></div>
        <a href="{{ route('sessions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Session
        </a>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">#</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Session Name</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Start Date</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">End Date</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Semesters</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Current</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sessions as $i => $session)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-gray-400">{{ $sessions->firstItem() + $i }}</td>
                    <td class="px-5 py-3 font-medium text-gray-900">{{ $session->name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $session->start_date->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $session->end_date->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $session->semesters_count }}</td>
                    <td class="px-5 py-3">
                        @if($session->is_current)<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Current</span>@else<span class="text-gray-400 text-xs">—</span>@endif
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('sessions.edit', $session) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                            <form method="POST" action="{{ route('sessions.destroy', $session) }}" onsubmit="return confirm('Delete this session?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-12 text-center text-gray-400">No sessions yet. <a href="{{ route('sessions.create') }}" class="text-blue-600">Add one →</a></td></tr>
                @endforelse
            </tbody>
        </table>
        @if($sessions->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $sessions->links() }}</div>@endif
    </div>
</x-app-layout>
