<x-app-layout>
    <x-slot name="title">Edit Faculty</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('faculties.index')
        <a href="{{ route('faculties.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        @endaccess
        <div><h1 class="text-2xl font-bold text-gray-900">Edit Faculty</h1><p class="text-sm text-gray-500">{{ $faculty->name }}</p></div>
    </div>
    <div class="max-w-2xl">
        @access('faculties.update')
        <form method="POST" action="{{ route('faculties.update', $faculty) }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Faculty Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $faculty->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Short Name <span class="text-red-500">*</span></label>
                    <input type="text" name="short_name" value="{{ old('short_name', $faculty->short_name) }}" required maxlength="10" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('short_name') border-red-400 @enderror">
                    @error('short_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                    <input type="text" name="code" value="{{ old('code', $faculty->code) }}" maxlength="20" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $faculty->description) }}</textarea>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $faculty->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
                <label for="is_active" class="text-sm text-gray-700">Active</label>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update Faculty</button>
                @access('faculties.index')
                <a href="{{ route('faculties.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
                @endaccess
            </div>
        </form>
                @endaccess
    </div>
</x-app-layout>
