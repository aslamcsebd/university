<x-app-layout>
    <x-slot name="title">Add Batch</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('batches.index')
        <a href="{{ route('batches.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <h1 class="text-2xl font-bold text-gray-900">Add Batch</h1>
    </div>
    <div class="max-w-2xl">
        @access('batches.store')
        <form method="POST" action="{{ route('batches.store') }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program <span class="text-red-500">*</span></label>
                    <select name="program_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('program_id') border-red-400 @enderror">
                        <option value="">— Select Program —</option>
                        @foreach($programs as $p)<option value="{{ $p->id }}" {{ old('program_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->short_name }})</option>@endforeach
                    </select>
                    @error('program_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Academic Session <span class="text-red-500">*</span></label>
                    <select name="academic_session_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('academic_session_id') border-red-400 @enderror">
                        <option value="">— Select Session —</option>
                        @foreach($sessions as $s)<option value="{{ $s->id }}" {{ old('academic_session_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach
                    </select>
                    @error('academic_session_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batch Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. CSE-2025" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Intake Year</label>
                    <input type="number" name="intake_year" value="{{ old('intake_year', date('Y')) }}" min="2000" max="2100" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Students</label>
                    <input type="number" name="max_students" value="{{ old('max_students', 0) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">0 = unlimited</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-gray-300 text-blue-600">
                <label for="is_active" class="text-sm text-gray-700">Active</label>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Create Batch</button>
                @access('batches.index')
                <a href="{{ route('batches.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
                @endaccess
            </div>
        </form>
                @endaccess
    </div>
</x-app-layout>
