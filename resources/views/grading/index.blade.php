<x-app-layout>
    <x-slot name="title">Grading Systems</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Grading Systems</h1><p class="text-sm text-gray-500 mt-1">Configure grade scales and GPA rules</p></div>
        @access('grading.create')
        <a href="{{ route('grading.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Grading System
        </a>
        @endaccess
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($systems as $system)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $system->name }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Max GPA: {{ $system->max_gpa }} · {{ $system->grade_rules_count }} grades</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($system->is_default)<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">Default</span>@endif
                    @access('grading.edit')
                    <a href="{{ route('grading.edit', $system) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                    @endaccess
                    @access('grading.destroy')
                    <form method="POST" action="{{ route('grading.destroy', $system) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                    </form>
                    @endaccess
                </div>
            </div>
            @if($system->description)<p class="text-xs text-gray-500 mb-3">{{ $system->description }}</p>@endif
            @access('grading.edit')
            <a href="{{ route('grading.edit', $system) }}" class="text-xs text-blue-600 hover:underline">Edit grade rules →</a>
            @endaccess
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-400">
            No grading systems yet. @access('grading.create')
<a href="{{ route('grading.create') }}" class="text-blue-600">Create one →</a>
            @endaccess
        </div>
        @endforelse
    </div>
</x-app-layout>
