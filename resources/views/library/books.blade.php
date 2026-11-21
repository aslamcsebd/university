<x-app-layout>
    <x-slot name="title">Library — Books</x-slot>
    <div class="mb-6 flex items-center justify-between">
        <div><h1 class="text-2xl font-bold text-gray-900">Book Catalogue</h1><p class="text-sm text-gray-500 mt-1">Manage the library book collection</p></div>
        <div class="flex gap-2">
            @access('library.members')
            <a href="{{ route('library.members') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Members</a>
            @endaccess
            @access('library.issue')
            <a href="{{ route('library.issue') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Issue/Return</a>
            @endaccess
            @access('library.overdue')
            <a href="{{ route('library.overdue') }}" class="px-4 py-2 border border-red-300 text-red-600 rounded-lg text-sm hover:bg-red-50">Overdue</a>
            @endaccess
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
                <form method="GET" class="flex gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title, author, ISBN..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $c)<option value="{{ $c->id }}" {{ request('category')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Search</button>
                </form>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Title</th><th class="text-left px-5 py-3 font-medium text-gray-600">Author</th><th class="text-left px-5 py-3 font-medium text-gray-600">Category</th><th class="text-left px-5 py-3 font-medium text-gray-600">Copies</th><th class="text-left px-5 py-3 font-medium text-gray-600">Available</th><th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($books as $book)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ Str::limit($book->title,40) }}</p><p class="text-xs text-gray-400">{{ $book->isbn ?? 'No ISBN' }}</p></td>
                            <td class="px-5 py-3 text-gray-500">{{ $book->author ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $book->category?->name }}</td>
                            <td class="px-5 py-3 text-gray-700">{{ $book->quantity }}</td>
                            <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $book->available > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $book->available }}</span></td>
                            <td class="px-5 py-3 text-right">
                                @access('library.books.destroy')
                                <form method="POST" action="{{ route('library.books.destroy', $book) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </form>
                                @endaccess
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400">No books yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($books->hasPages())<div class="px-5 py-4 border-t">{{ $books->links() }}</div>@endif
            </div>
        </div>
        <div class="space-y-5">
            @access('library.books.store')
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Add Book</h3>
                <form method="POST" action="{{ route('library.books.store') }}" class="space-y-3">
                    @csrf
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Category *</label>
                        <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— Select —</option>
                            @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                        </select>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Title *</label><input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Author</label><input type="text" name="author" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">ISBN</label><input type="text" name="isbn" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Copies *</label><input type="number" name="quantity" required min="1" value="1" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Shelf No</label><input type="text" name="shelf_no" placeholder="e.g. A-01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Book</button>
                </form>
            </div>
            @endaccess
            @access('library.categories.store')
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Add Category</h3>
                <form method="POST" action="{{ route('library.categories.store') }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Category name" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Add</button>
                </form>
            </div>
            @endaccess
        </div>
    </div>
</x-app-layout>
