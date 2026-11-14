@props(['href' => '#', 'icon' => 'dot', 'active' => false])

<a href="{{ $href }}"
   class="{{ $active
        ? 'bg-blue-600 text-white'
        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
   flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors">
    <x-sidebar-icon :name="$icon" class="w-4 h-4 shrink-0"/>
    <span x-show="sidebarOpen" class="truncate">{{ $slot }}</span>
</a>
