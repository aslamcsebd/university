<x-app-layout>
    <x-slot name="title">Edit Program</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('programs.index')
        <a href="{{ route('programs.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <div><h1 class="text-2xl font-bold text-gray-900">Edit Program</h1><p class="text-sm text-gray-500">{{ $program->name }}</p></div>
    </div>
    <div class="max-w-2xl">
        @access('programs.update')
        <form method="POST" action="{{ route('programs.update', $program) }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $program->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Short Name <span class="text-red-500">*</span></label>
                    <input type="text" name="short_name" value="{{ old('short_name', $program->short_name) }}" required maxlength="20" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('short_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                    <input type="text" name="code" value="{{ old('code', $program->code) }}" maxlength="20" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department <span class="text-red-500">*</span></label>
                    <select name="department_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id', $program->department_id) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Level <span class="text-red-500">*</span></label>
                    <select name="level" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($levels as $l)<option value="{{ $l }}" {{ old('level', $program->level) == $l ? 'selected' : '' }}>{{ ucfirst($l) }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration (Years) <span class="text-red-500">*</span></label>
                    <input type="number" name="duration_years" value="{{ old('duration_years', $program->duration_years) }}" required min="0.5" max="10" step="0.5" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Credits</label>
                    <input type="number" name="total_credits" value="{{ old('total_credits', $program->total_credits) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $program->description) }}</textarea>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $program->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
                <label for="is_active" class="text-sm text-gray-700">Active</label>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update Program</button>
                @access('programs.index')
                <a href="{{ route('programs.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
                @endaccess
            </div>
        </form>
                @endaccess
    </div>
</x-app-layout>
