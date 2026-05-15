<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome back, <strong>{{ Auth::user()->name }}</strong>! You're logged in.
                </div>
            </div>

            {{-- Academic Module Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Academic Timetable Module</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                        @foreach([
                            ['label'=>'Staff',     'icon'=>'👤', 'url'=>'/academic/staff',     'color'=>'#e0e7ff', 'text'=>'#4338ca'],
                            ['label'=>'Terms',     'icon'=>'📅', 'url'=>'/academic/terms',     'color'=>'#dcfce7', 'text'=>'#166534'],
                            ['label'=>'Courses',   'icon'=>'📚', 'url'=>'/academic/courses',   'color'=>'#fef9c3', 'text'=>'#854d0e'],
                            ['label'=>'Rooms',     'icon'=>'🏫', 'url'=>'/academic/rooms',     'color'=>'#fee2e2', 'text'=>'#991b1b'],
                            ['label'=>'Timetable', 'icon'=>'🗓️', 'url'=>'/academic/timetable', 'color'=>'#f3e8ff', 'text'=>'#6b21a8'],
                            ['label'=>'Overview',  'icon'=>'📊', 'url'=>'/academic/overview',  'color'=>'#e0f2fe', 'text'=>'#0369a1'],
                        ] as $card)
                        <a href="{{ $card['url'] }}"
                           style="background:{{ $card['color'] }}; color:{{ $card['text'] }}; text-decoration:none; border-radius:10px; padding:20px 12px; display:flex; flex-direction:column; align-items:center; gap:8px; font-weight:600; font-size:13px; transition:opacity .15s;"
                           onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
                            <span style="font-size:28px;">{{ $card['icon'] }}</span>
                            {{ $card['label'] }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
