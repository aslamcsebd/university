<x-app-layout>
    <x-slot name="title">Edit Batch</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('batches.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <div><h1 class="text-2xl font-bold text-gray-900">Edit Batch</h1><p class="text-sm text-gray-500">{{ $batch->name }}</p></div>
    </div>
    <div class="max-w-3xl space-y-5">
        <form method="POST" action="{{ route('batches.update', $batch) }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program <span class="text-red-500">*</span></label>
                    <select name="program_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($programs as $p)<option value="{{ $p->id }}" {{ old('program_id', $batch->program_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Academic Session <span class="text-red-500">*</span></label>
                    <select name="academic_session_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($sessions as $s)<option value="{{ $s->id }}" {{ old('academic_session_id', $batch->academic_session_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batch Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $batch->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Intake Year</label>
                    <input type="number" name="intake_year" value="{{ old('intake_year', $batch->intake_year) }}" min="2000" max="2100" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Students</label>
                    <input type="number" name="max_students" value="{{ old('max_students', $batch->max_students) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $batch->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
                <label class="text-sm text-gray-700">Active</label>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update Batch</button>
                <a href="{{ route('batches.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
            </div>
        </form>

        {{-- Sections --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Sections</h2>
                <span class="text-xs text-gray-400">{{ $batch->sections->count() }} section(s)</span>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr><th class="text-left px-5 py-2 font-medium text-gray-600">Name</th><th class="text-left px-5 py-2 font-medium text-gray-600">Capacity</th><th class="text-right px-5 py-2 font-medium text-gray-600">Remove</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($batch->sections as $section)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 font-medium text-gray-900">Section {{ $section->name }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $section->capacity ?? 'Unlimited' }}</td>
                        <td class="px-5 py-2 text-right">
                            <form method="POST" action="{{ route('batches.sections.destroy', [$batch, $section]) }}" onsubmit="return confirm('Remove this section?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-6 text-center text-gray-400">No sections yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-gray-100 p-5">
                <p class="text-sm font-medium text-gray-700 mb-3">Add Section</p>
                <form method="POST" action="{{ route('batches.sections.store', $batch) }}" class="flex gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="Section name (e.g. A, B, Morning)" required class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="number" name="capacity" placeholder="Capacity (optional)" min="1" class="w-36 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
