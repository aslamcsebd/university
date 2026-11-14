<x-app-layout>
    <x-slot name="title">Book List</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Book List</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $books->total() }} books in catalogue</p>
        </div>
        <button onclick="document.getElementById('add-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Book
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <form method="GET" class="flex gap-3 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title, author, ISBN..."
               class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
        @if(request()->hasAny(['search','category']))
            <a href="{{ route('books.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Clear</a>
        @endif
    </form>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Title</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Author</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Category</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">ISBN</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Copies</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Available</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($books as $book)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="font-semibold text-gray-900">{{ $book->title }}</div>
                        @if($book->shelf_no)<div class="text-xs text-gray-400">Shelf: {{ $book->shelf_no }}</div>@endif
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $book->author ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-medium">{{ $book->category->name }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500 font-mono text-xs">{{ $book->isbn ?? '—' }}</td>
                    <td class="px-4 py-3 text-center font-bold text-gray-700">{{ $book->quantity }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="font-bold {{ $book->available > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $book->available }}</span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end gap-2">
                            <button onclick='openEditBook({{ json_encode($book) }})'
                                    class="text-xs text-blue-600 hover:underline font-medium">Edit</button>
                            <form method="POST" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Delete this book?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:underline font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">No books found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $books->links() }}</div>
    </div>

    {{-- Add Modal --}}
    <div id="add-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-lg mx-4">
            <h3 class="font-bold text-gray-900 mb-4">Add Book</h3>
            <form method="POST" action="{{ route('books.store') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Title *</label>
                        <input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Author</label>
                        <input type="text" name="author" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Category *</label>
                        <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">ISBN</label>
                        <input type="text" name="isbn" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Quantity *</label>
                        <input type="number" name="quantity" min="1" value="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Publisher</label>
                        <input type="text" name="publisher" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Shelf No</label>
                        <input type="text" name="shelf_no" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Book</button>
                    <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="edit-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-lg mx-4">
            <h3 class="font-bold text-gray-900 mb-4">Edit Book</h3>
            <form method="POST" id="edit-form" class="space-y-3">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-3">
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Title *</label>
                        <input type="text" name="title" id="edit-title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Author</label>
                        <input type="text" name="author" id="edit-author" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Category *</label>
                        <select name="category_id" id="edit-category" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">ISBN</label>
                        <input type="text" name="isbn" id="edit-isbn" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Quantity *</label>
                        <input type="number" name="quantity" id="edit-quantity" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Publisher</label>
                        <input type="text" name="publisher" id="edit-publisher" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Shelf No</label>
                        <input type="text" name="shelf_no" id="edit-shelf" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update</button>
                    <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEditBook(book) {
            document.getElementById('edit-form').action = '/books/' + book.id;
            document.getElementById('edit-title').value = book.title;
            document.getElementById('edit-author').value = book.author || '';
            document.getElementById('edit-category').value = book.category_id;
            document.getElementById('edit-isbn').value = book.isbn || '';
            document.getElementById('edit-quantity').value = book.quantity;
            document.getElementById('edit-publisher').value = book.publisher || '';
            document.getElementById('edit-shelf').value = book.shelf_no || '';
            document.getElementById('edit-modal').classList.remove('hidden');
        }
    </script>
    @endpush
</x-app-layout>
