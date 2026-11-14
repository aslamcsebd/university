<x-app-layout>
    <x-slot name="title">Notifications</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Notifications</h1><p class="text-sm text-gray-500 mt-1">Your system notifications</p></div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="divide-y divide-gray-100">
            @forelse($notifications as $n)
            <div class="px-5 py-4 {{ $n->read_at ? 'bg-white' : 'bg-blue-50' }}">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-medium text-gray-900 text-sm">{{ $n->title }}</p>
                        @if($n->body)<p class="text-xs text-gray-500 mt-0.5">{{ $n->body }}</p>@endif
                    </div>
                    <p class="text-xs text-gray-400 shrink-0 ml-4">{{ $n->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div class="p-12 text-center text-gray-400">No notifications.</div>
            @endforelse
        </div>
        @if($notifications->hasPages())<div class="px-5 py-4 border-t">{{ $notifications->links() }}</div>@endif
    </div>
</x-app-layout>
