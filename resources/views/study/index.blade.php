<x-app-layout>
    <x-slot name="title">Study Materials</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Study Materials</h1><p class="text-sm text-gray-500 mt-1">Lecture notes, slides, assignments and resources</p></div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Content List --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Materials</h2></div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Title</th><th class="text-left px-5 py-2 font-medium text-gray-600">Course</th><th class="text-left px-5 py-2 font-medium text-gray-600">Type</th><th class="text-left px-5 py-2 font-medium text-gray-600">Size</th><th class="text-right px-5 py-2 font-medium text-gray-600">Del</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($contents as $c)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-2 font-medium text-gray-900">{{ $c->title }}</td>
                            <td class="px-5 py-2 text-gray-500">{{ $c->sessionCourse?->course?->name }}</td>
                            <td class="px-5 py-2"><span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">{{ $c->contentType?->name ?? 'General' }}</span></td>
                            <td class="px-5 py-2 text-gray-400">{{ $c->file_size ?? '—' }}</td>
                            <td class="px-5 py-2 text-right">
                                @access('study-materials.contents.destroy')
                                <form method="POST" action="{{ route('study-materials.contents.destroy', $c) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                    <button type="submit" class="p-1 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </form>
                                @endaccess
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">No materials yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Assignments</h2></div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Title</th><th class="text-left px-5 py-2 font-medium text-gray-600">Course</th><th class="text-left px-5 py-2 font-medium text-gray-600">Due Date</th><th class="text-left px-5 py-2 font-medium text-gray-600">Marks</th><th class="text-right px-5 py-2 font-medium text-gray-600">Del</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($assignments as $a)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-2 font-medium text-gray-900">{{ $a->title }}</td>
                            <td class="px-5 py-2 text-gray-500">{{ $a->sessionCourse?->course?->name }}</td>
                            <td class="px-5 py-2 {{ $a->due_date->isPast() ? 'text-red-600' : 'text-gray-500' }}">{{ $a->due_date->format('d M Y') }}</td>
                            <td class="px-5 py-2 text-gray-500">{{ $a->max_marks ?? '—' }}</td>
                            <td class="px-5 py-2 text-right">
                                @access('study-materials.assignments.destroy')
                                <form method="POST" action="{{ route('study-materials.assignments.destroy', $a) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                    <button type="submit" class="p-1 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </form>
                                @endaccess
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">No assignments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Forms --}}
        <div class="space-y-5">
            @access('study-materials.contents.store')
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Upload Material</h3>
                <form method="POST" action="{{ route('study-materials.contents.store') }}" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Course *</label>
                        <select name="session_course_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— Select —</option>
                            @foreach($courses as $c)<option value="{{ $c->id }}">{{ $c->course?->name }}</option>@endforeach
                        </select>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                        <select name="content_type_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">General</option>
                            @foreach($types as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach
                        </select>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Title *</label><input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">File</label><input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.mp4" class="w-full text-sm text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700"></div>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Upload</button>
                </form>
            </div>
            @endaccess
            @access('study-materials.assignments.store')
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Create Assignment</h3>
                <form method="POST" action="{{ route('study-materials.assignments.store') }}" class="space-y-3">
                    @csrf
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Course *</label>
                        <select name="session_course_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— Select —</option>
                            @foreach($courses as $c)<option value="{{ $c->id }}">{{ $c->course?->name }}</option>@endforeach
                        </select>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Title *</label><input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Due Date *</label><input type="date" name="due_date" required class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Max Marks</label><input type="number" name="max_marks" min="0" step="0.5" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    </div>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Create</button>
                </form>
            </div>
            @endaccess
        </div>
    </div>
</x-app-layout>
