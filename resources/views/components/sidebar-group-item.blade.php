@php
    $isActive = $active ?? false;
    $groupKey = 'sidebar_' . \Illuminate\Support\Str::slug($label);
@endphp

<div x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">

    {{-- Group Header --}}
    <button @click="open = !open; if(!sidebarOpen) sidebarOpen = true"
            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium transition-colors
                   {{ $isActive ? 'text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <div class="flex items-center gap-3">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
            <span x-show="sidebarOpen" x-cloak>{{ $label }}</span>
        </div>
        <svg x-show="sidebarOpen" x-cloak
             :class="open ? 'rotate-90' : ''"
             class="w-3 h-3 transition-transform shrink-0"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- Children --}}
    <div x-show="open && sidebarOpen"
         x-collapse
         x-cloak
         class="mt-0.5 ml-3 pl-4 border-l border-slate-700 space-y-0.5">
        @foreach($items as $item)
        <a href="{{ route($item['route']) }}"
           class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-[13px] leading-5 transition-colors
                  {{ request()->routeIs($item['route'].'*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70 shrink-0"></span>
            <span class="truncate">{{ $item['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>
