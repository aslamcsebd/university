<x-app-layout>
    <x-slot name="title">Events</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Events</h1></div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2">
            <div class="space-y-4">
                @forelse($events as $event)
                <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-start gap-4">
                    <div class="text-center bg-blue-50 rounded-lg p-3 w-16 shrink-0">
                        <p class="text-2xl font-bold text-blue-700">{{ $event->start_at->format('d') }}</p>
                        <p class="text-xs text-blue-600">{{ $event->start_at->format('M') }}</p>
                    </div>
                    <div class="flex-1">
                        @access('events.destroy')
                        <div class="flex items-start justify-between">
                            <h3 class="font-semibold text-gray-900">{{ $event->title }}</h3>
                            <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </div>
                        @endaccess
                        <p class="text-sm text-gray-500 mt-1">{{ $event->start_at->format('d M Y H:i') }} – {{ $event->end_at->format('H:i') }}</p>
                        @if($event->location)<p class="text-xs text-gray-400 mt-0.5">📍 {{ $event->location }}</p>@endif
                        <div class="flex items-center gap-2 mt-2">
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">{{ ucfirst($event->audience) }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $event->is_published?'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700' }}">{{ $event->is_published?'Published':'Draft' }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-400">No events yet.</div>
                @endforelse
                @if($events->hasPages())<div class="mt-4">{{ $events->links() }}</div>@endif
            </div>
        </div>
        @access('events.store')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Create Event</h3>
            <form method="POST" action="{{ route('events.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Title *</label><input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Description</label><textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Start *</label><input type="datetime-local" name="start_at" required class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">End *</label><input type="datetime-local" name="end_at" required class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Location</label><input type="text" name="location" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Audience</label>
                    <select name="audience" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All</option><option value="students">Students</option><option value="staff">Staff</option><option value="public">Public</option>
                    </select>
                </div>
                <div class="flex items-center gap-2"><input type="checkbox" name="is_published" value="1" checked class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Publish immediately</label></div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Create Event</button>
            </form>
        </div>
        @endaccess
    </div>
</x-app-layout>
