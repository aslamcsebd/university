<x-app-layout>
    <x-slot name="title">Edit Session</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('sessions.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <div><h1 class="text-2xl font-bold text-gray-900">Edit Session</h1><p class="text-sm text-gray-500">{{ $session->name }}</p></div>
    </div>
    <div class="max-w-3xl space-y-5">
        {{-- Session form --}}
        <form method="POST" action="{{ route('sessions.update', $session) }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Session Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $session->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ old('start_date', $session->start_date->format('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" value="{{ old('end_date', $session->end_date->format('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_current" id="is_current" value="1" {{ old('is_current', $session->is_current) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
                <label for="is_current" class="text-sm text-gray-700">Set as Current Session</label>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update Session</button>
                <a href="{{ route('sessions.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
            </div>
        </form>

        {{-- Semesters --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Semesters</h2>
                <span class="text-xs text-gray-400">{{ $session->semesters->count() }} semester(s)</span>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-2 font-medium text-gray-600">Name</th>
                        <th class="text-left px-5 py-2 font-medium text-gray-600">Term</th>
                        <th class="text-left px-5 py-2 font-medium text-gray-600">Start</th>
                        <th class="text-left px-5 py-2 font-medium text-gray-600">End</th>
                        <th class="text-left px-5 py-2 font-medium text-gray-600">Current</th>
                        <th class="text-right px-5 py-2 font-medium text-gray-600">Remove</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($session->semesters as $sem)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 font-medium text-gray-900">{{ $sem->name }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $sem->term }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $sem->start_date?->format('d M Y') ?? '—' }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $sem->end_date?->format('d M Y') ?? '—' }}</td>
                        <td class="px-5 py-2">@if($sem->is_current)<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">Current</span>@else<span class="text-gray-400 text-xs">—</span>@endif</td>
                        <td class="px-5 py-2 text-right">
                            <form method="POST" action="{{ route('sessions.semesters.destroy', [$session, $sem]) }}" onsubmit="return confirm('Remove this semester?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-6 text-center text-gray-400">No semesters yet.</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Add semester --}}
            <div class="border-t border-gray-100 p-5">
                <p class="text-sm font-medium text-gray-700 mb-3">Add Semester</p>
                <form method="POST" action="{{ route('sessions.semesters.store', $session) }}" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="e.g. Fall 2025" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select name="term" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">Term 1</option>
                        <option value="2">Term 2</option>
                        <option value="3">Term 3</option>
                    </select>
                    <input type="date" name="start_date" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="date" name="end_date" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_current" value="1" class="rounded border-gray-300 text-blue-600">
                        <span class="text-sm text-gray-600">Set Current</span>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
