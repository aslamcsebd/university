<x-app-layout>
    <x-slot name="title">Audit Logs</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Audit Logs</h1>
        <p class="text-sm text-gray-500 mt-1">Track all system activity and changes</p>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search description or model..."
                   class="flex-1 min-w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="event" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Events</option>
                <option value="created" {{ request('event') === 'created' ? 'selected' : '' }}>Created</option>
                <option value="updated" {{ request('event') === 'updated' ? 'selected' : '' }}>Updated</option>
                <option value="deleted" {{ request('event') === 'deleted' ? 'selected' : '' }}>Deleted</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm hover:bg-gray-700 transition-colors">Filter</button>
            @if(request()->hasAny(['search','event','date_from','date_to']))
                @access('audit.index')
<a href="{{ route('audit.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors">Clear</a>
@endaccess

            @endif
        </form>
    </div>

    {{-- Activity Log Table --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-5">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">Activity Log</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Event</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Description</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Model</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">By</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        @php
                            $eventColors = [
                                'created' => 'bg-green-100 text-green-700',
                                'updated' => 'bg-blue-100 text-blue-700',
                                'deleted' => 'bg-red-100 text-red-700',
                            ];
                            $color = $eventColors[$log->event] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                            {{ $log->event ?? 'log' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-700">{{ Str::limit($log->description, 60) }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">
                        {{ $log->subject_type ? class_basename($log->subject_type) : '—' }}
                        @if($log->subject_id) <span class="text-gray-400">#{{ Str::limit($log->subject_id, 8, '') }}</span> @endif
                    </td>
                    <td class="px-5 py-3">
                        @if($log->causer)
                            <div class="flex items-center gap-2">
                                <img src="{{ $log->causer->avatar_url }}" class="w-6 h-6 rounded-full" alt="">
                                <span class="text-gray-700">{{ $log->causer->name }}</span>
                            </div>
                        @else
                            <span class="text-gray-400">System</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">No activity logs found</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($logs->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $logs->links() }}</div>
        @endif
    </div>

    {{-- Login Audit --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">Recent Login Activity</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">User</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">IP Address</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($loginAudits as $audit)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <div>
                            <p class="font-medium text-gray-800">{{ $audit->user?->name ?? 'Unknown' }}</p>
                            <p class="text-xs text-gray-400">{{ $audit->email }}</p>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $audit->status === 'success' ? 'bg-green-100 text-green-700' :
                               ($audit->status === 'locked' ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700') }}">
                            {{ $audit->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $audit->ip_address ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $audit->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">No login records</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
