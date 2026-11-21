<x-app-layout>
    <x-slot name="title">{{ $teacher->full_name }}</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('teachers.index')
        <a href="{{ route('teachers.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <h1 class="text-2xl font-bold text-gray-900">Teacher Profile</h1>
        @access('teachers.edit')
        <a href="{{ route('teachers.edit', $teacher) }}" class="ml-auto px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Edit</a>
        @endaccess
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 p-5 text-center">
            <img src="{{ $teacher->photo_url }}" class="w-20 h-20 rounded-full mx-auto mb-3 object-cover">
            <h2 class="font-semibold text-gray-900">{{ $teacher->full_name }}</h2>
            <p class="text-xs text-gray-500 mt-0.5">{{ $teacher->designation?->name }}</p>
            <p class="text-xs font-mono text-blue-600 mt-1">{{ $teacher->employee_id }}</p>
            <span class="mt-2 inline-block px-2 py-0.5 rounded-full text-xs {{ $teacher->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $teacher->is_active ? 'Active' : 'Inactive' }}</span>
        </div>
        <div class="lg:col-span-3 bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Academic Details</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                <div><p class="text-gray-500">Department</p><p class="font-medium">{{ $teacher->department?->name ?? '—' }}</p></div>
                <div><p class="text-gray-500">Designation</p><p class="font-medium">{{ $teacher->designation?->name ?? '—' }}</p></div>
                <div><p class="text-gray-500">Specialization</p><p class="font-medium">{{ $teacher->specialization ?? '—' }}</p></div>
                <div><p class="text-gray-500">Highest Degree</p><p class="font-medium">{{ $teacher->highest_degree ?? '—' }}</p></div>
                <div><p class="text-gray-500">Institution</p><p class="font-medium">{{ $teacher->institution ?? '—' }}</p></div>
                <div><p class="text-gray-500">Experience</p><p class="font-medium">{{ $teacher->experience_years }} years</p></div>
                <div><p class="text-gray-500">Employment Type</p><p class="font-medium">{{ ucfirst(str_replace('_',' ',$teacher->employment_type)) }}</p></div>
                <div><p class="text-gray-500">Join Date</p><p class="font-medium">{{ $teacher->join_date?->format('d M Y') ?? '—' }}</p></div>
                <div><p class="text-gray-500">Login Email</p><p class="font-medium">{{ $teacher->user?->email ?? '—' }}</p></div>
            </div>
        </div>
    </div>
</x-app-layout>
