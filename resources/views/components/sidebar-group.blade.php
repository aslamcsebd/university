@props(['label', 'icon' => 'folder'])

@php
    $isActive = false;
    // Check if any child link is active by looking at the slot content
@endphp

<div x-data="{ open: {{ request()->is(strtolower($label).'/*') ? 'true' : 'false' }} }" class="space-y-0.5">
    <button @click="open = !open"
            x-show="sidebarOpen"
            class="w-full flex items-center justify-between px-3 py-2 text-sm text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors">
        <div class="flex items-center gap-2">
            <x-sidebar-icon :name="$icon" class="w-4 h-4 shrink-0"/>
            <span>{{ $label }}</span>
        </div>
        <svg :class="open ? 'rotate-90' : ''" class="w-3 h-3 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- Collapsed: show icon only --}}
    <button x-show="!sidebarOpen" @click="sidebarOpen = true; open = true"
            class="w-full flex items-center justify-center py-2 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors"
            title="{{ $label }}">
        <x-sidebar-icon :name="$icon" class="w-4 h-4"/>
    </button>

    <div x-show="open && sidebarOpen" x-collapse class="pl-4 space-y-0.5">
        {{ $slot }}
    </div>
</div>
