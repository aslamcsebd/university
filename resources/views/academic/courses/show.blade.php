<x-app-layout>
    <x-slot name="title">{{ $course->name }}</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('courses.index')
        <a href="{{ route('courses.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <div><h1 class="text-2xl font-bold text-gray-900">{{ $course->name }}</h1><p class="text-sm text-gray-500">{{ $course->code }}</p></div>
        @access('courses.edit')
        <a href="{{ route('courses.edit', $course) }}" class="ml-auto px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Edit Course</a>
        @endaccess
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Course Details</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500">Code</dt><dd class="font-mono font-medium text-blue-600">{{ $course->code }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Department</dt><dd class="font-medium text-gray-900">{{ $course->department?->name ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Credit Hours</dt><dd class="font-medium text-gray-900">{{ $course->credit_hours }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Type</dt><dd class="font-medium text-gray-900">{{ ucfirst($course->type) }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Status</dt><dd><span class="px-2 py-0.5 rounded-full text-xs {{ $course->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $course->is_active ? 'Active' : 'Inactive' }}</span></dd></div>
            </dl>
            @if($course->description)<p class="mt-4 text-sm text-gray-500 border-t border-gray-100 pt-3">{{ $course->description }}</p>@endif
        </div>
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Subjects <span class="text-gray-400 text-sm font-normal">({{ $course->subjects->count() }})</span></h3>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr><th class="text-left px-5 py-2 font-medium text-gray-600">Name</th><th class="text-left px-5 py-2 font-medium text-gray-600">Code</th><th class="text-right px-5 py-2 font-medium text-gray-600">Remove</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($course->subjects as $sub)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 font-medium text-gray-900">{{ $sub->name }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $sub->code ?? '—' }}</td>
                        <td class="px-5 py-2 text-right">
                            @access('courses.subjects.destroy')
                            <form method="POST" action="{{ route('courses.subjects.destroy', [$course, $sub]) }}" onsubmit="return confirm('Remove this subject?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                            @endaccess
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-6 text-center text-gray-400">No subjects yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-gray-100 p-5">
                <p class="text-sm font-medium text-gray-700 mb-3">Add Subject</p>
                @access('courses.subjects.store')
                <form method="POST" action="{{ route('courses.subjects.store', $course) }}" class="flex gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="Subject name" required class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="text" name="code" placeholder="Code (optional)" class="w-32 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add</button>
                </form>
                @endaccess
            </div>
        </div>
    </div>
</x-app-layout>
