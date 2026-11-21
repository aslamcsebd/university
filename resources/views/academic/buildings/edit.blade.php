<x-app-layout>
    <x-slot name="title">Edit Building</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('buildings.index')
        <a href="{{ route('buildings.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <div><h1 class="text-2xl font-bold text-gray-900">Edit Building</h1><p class="text-sm text-gray-500">{{ $building->name }}</p></div>
    </div>
    <div class="max-w-2xl">
        @access('buildings.update')
        <form method="POST" action="{{ route('buildings.update', $building) }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Campus <span class="text-red-500">*</span></label>
                <select name="campus_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($campuses as $c)<option value="{{ $c->id }}" {{ old('campus_id', $building->campus_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Building Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $building->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Number of Floors</label>
                <input type="number" name="floors" value="{{ old('floors', $building->floors) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $building->description) }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $building->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
                <label for="is_active" class="text-sm text-gray-700">Active</label>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update Building</button>
                @access('buildings.index')
                <a href="{{ route('buildings.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
                @endaccess
            </div>
        </form>
                @endaccess
    </div>
</x-app-layout>
