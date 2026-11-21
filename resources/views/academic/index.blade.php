<x-app-layout>
    <x-slot name="title">Academic Overview</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Academic Overview</h1>
        <p class="text-sm text-gray-500 mt-1">University academic structure at a glance</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        @foreach([
            ['label' => 'Faculties',    'value' => $stats['faculties'],   'color' => 'blue',   'route' => 'faculties.index'],
            ['label' => 'Departments',  'value' => $stats['departments'], 'color' => 'purple', 'route' => 'departments.index'],
            ['label' => 'Programs',     'value' => $stats['programs'],    'color' => 'green',  'route' => 'programs.index'],
            ['label' => 'Courses',      'value' => $stats['courses'],     'color' => 'yellow', 'route' => 'courses.index'],
            ['label' => 'Campuses',     'value' => $stats['campuses'],    'color' => 'red',    'route' => 'campuses.index'],
            ['label' => 'Sessions',     'value' => $stats['sessions'],    'color' => 'indigo', 'route' => 'sessions.index'],
        ] as $stat)
        <a href="{{ route($stat['route']) }}"
           class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-sm transition-shadow">
            <p class="text-2xl font-bold text-{{ $stat['color'] }}-600">{{ $stat['value'] }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $stat['label'] }}</p>
        </a>
        @endforeach
    </div>

    {{-- Current Session --}}
    @if($currentSession)
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-center gap-3">
        <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <div>
            <span class="text-sm font-semibold text-blue-800">Current Session: {{ $currentSession->name }}</span>
            <span class="text-xs text-blue-600 ml-2">{{ $currentSession->start_date->format('d M Y') }} – {{ $currentSession->end_date->format('d M Y') }}</span>
        </div>
    </div>
    @else
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6 text-sm text-yellow-800">
        No current academic session set. @access('sessions.create')
<a href="{{ route('sessions.create') }}" class="font-medium underline">Create one →</a>
@endaccess
    </div>
    @endif

    {{-- Faculties Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($faculties as $faculty)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $faculty->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $faculty->short_name }}</p>
                </div>
                <span class="px-2 py-0.5 text-xs rounded-full {{ $faculty->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $faculty->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="flex gap-4 text-sm text-gray-600">
                <span>{{ $faculty->departments_count }} Departments</span>
                <span>{{ $faculty->programs_count }} Programs</span>
            </div>
            <div class="mt-3 flex gap-2">
                @access('departments.index')
                <a href="{{ route('departments.index', ['faculty' => $faculty->id]) }}"
                   class="text-xs text-blue-600 hover:underline">View Departments →</a>
                @endaccess
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-400">
            No faculties yet.
            @access('faculties.create')
            <a href="{{ route('faculties.create') }}" class="text-blue-600 hover:underline ml-1">Create the first faculty →</a>
            @endaccess
        </div>
        @endforelse
    </div>
</x-app-layout>
