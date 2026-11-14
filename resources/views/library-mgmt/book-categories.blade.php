<x-app-layout>
    <x-slot name="title">Book Categories</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Book Categories</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $categories->count() }} categories</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">#</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Name</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Description</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-600">Books</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $cat->name }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $cat->description ?? '—' }}</td>
                        <td class="px-4 py-3 text-center font-bold text-indigo-600">{{ $cat->books_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="openEdit({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->description) }}')"
                                        class="text-xs text-blue-600 hover:underline font-medium">Edit</button>
                                <form method="POST" action="{{ route('book-categories.destroy', $cat) }}" onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:underline font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4" id="form-title">Add Category</h3>
            <form method="POST" id="cat-form" action="{{ route('book-categories.store') }}">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="cat-name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="cat-desc" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Save</button>
                        <button type="button" onclick="resetForm()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEdit(id, name, desc) {
            document.getElementById('form-title').textContent = 'Edit Category';
            document.getElementById('cat-form').action = '/book-categories/' + id;
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('cat-name').value = name;
            document.getElementById('cat-desc').value = desc;
        }
        function resetForm() {
            document.getElementById('form-title').textContent = 'Add Category';
            document.getElementById('cat-form').action = '{{ route('book-categories.store') }}';
            document.getElementById('form-method').value = 'POST';
            document.getElementById('cat-name').value = '';
            document.getElementById('cat-desc').value = '';
        }
    </script>
    @endpush
</x-app-layout>
