<x-app-layout>
    <x-slot name="title">News</x-slot>
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('frontweb.pages.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <h1 class="text-2xl font-bold text-gray-900">News Articles</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Title</th><th class="text-left px-5 py-3 font-medium text-gray-600">Published</th><th class="text-left px-5 py-3 font-medium text-gray-600">Status</th><th class="text-right px-5 py-3 font-medium text-gray-600">Del</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($news as $n)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-900">{{ Str::limit($n->title,50) }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $n->published_at?->format('d M Y') ?? '—' }}</td>
                        <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $n->is_published?'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700' }}">{{ $n->is_published?'Published':'Draft' }}</span></td>
                        <td class="px-5 py-3 text-right"><form method="POST" action="{{ route('frontweb.news.destroy', $n) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="p-1 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-gray-400">No news articles yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($news->hasPages())<div class="px-5 py-4 border-t">{{ $news->links() }}</div>@endif
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Write Article</h3>
            <form method="POST" action="{{ route('frontweb.news.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Title *</label><input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Body *</label><textarea name="body" required rows="6" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea></div>
                <div class="flex items-center gap-2"><input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Publish immediately</label></div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Save Article</button>
            </form>
        </div>
    </div>
</x-app-layout>
