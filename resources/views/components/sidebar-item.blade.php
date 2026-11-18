@props(['href' => '#', 'icon' => 'dot', 'active' => false])

<a href="{{ $href }}"
   class="{{ $active
        ? 'bg-blue-600 text-white'
        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
   flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors">
    <x-sidebar-icon :name="$icon" class="w-4 h-4 shrink-0"/>
    <span x-show="sidebarOpen" x-cloak class="truncate">{{ $slot }}</span>
</a>
