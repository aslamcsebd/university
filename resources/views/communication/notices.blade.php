<x-app-layout>
    <x-slot name="title">Notices</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Notices & Announcements</h1></div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-4">
            @forelse($notices as $notice)
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center gap-2">
                        @if($notice->is_pinned)<span class="text-yellow-500 text-xs">📌 Pinned</span>@endif
                        @if($notice->category)<span class="px-2 py-0.5 rounded-full text-xs text-white" style="background-color:{{ $notice->category->color }}">{{ $notice->category->name }}</span>@endif
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">{{ ucfirst($notice->audience) }}</span>
                    </div>
                    <form method="POST" action="{{ route('notices.destroy', $notice) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                        <button type="submit" class="p-1 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                    </form>
                </div>
                <h3 class="font-semibold text-gray-900 text-lg">{{ $notice->title }}</h3>
                <p class="text-sm text-gray-600 mt-2 line-clamp-3">{{ Str::limit(strip_tags($notice->content), 200) }}</p>
                <div class="flex items-center gap-4 mt-3 text-xs text-gray-400">
                    <span>By {{ $notice->creator?->name }}</span>
                    <span>{{ $notice->published_at?->format('d M Y') }}</span>
                    @if($notice->expires_at)<span>Expires: {{ $notice->expires_at->format('d M Y') }}</span>@endif
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-400">No notices yet.</div>
            @endforelse
            @if($notices->hasPages())<div class="mt-4">{{ $notices->links() }}</div>@endif
        </div>
        <div class="space-y-5">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Post Notice</h3>
                <form method="POST" action="{{ route('notices.store') }}" class="space-y-3">
                    @csrf
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Title *</label><input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Content *</label><textarea name="content" required rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Audience</label>
                        <select name="audience" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all">All</option><option value="students">Students</option><option value="staff">Staff</option><option value="teachers">Teachers</option>
                        </select>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">No Category</option>
                            @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Publish At</label><input type="datetime-local" name="published_at" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Expires At</label><input type="datetime-local" name="expires_at" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    </div>
                    <div class="flex items-center gap-2"><input type="checkbox" name="is_pinned" value="1" class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Pin Notice</label></div>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Post Notice</button>
                </form>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Add Category</h3>
                <form method="POST" action="{{ route('notices.categories.store') }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Category name" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="color" name="color" value="#3b82f6" class="w-10 h-10 border border-gray-300 rounded-lg cursor-pointer">
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Add</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
