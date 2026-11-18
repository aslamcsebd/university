<header class="h-16 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800
               flex items-center justify-between px-4 shrink-0 transition-colors duration-200">

    <div class="flex items-center gap-3">
        {{-- Sidebar toggle --}}
        <button @click="sidebarOpen = !sidebarOpen"
                class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Breadcrumb --}}
        @isset($breadcrumb)
            <nav class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $breadcrumb }}
            </nav>
        @endisset
    </div>

    <div class="flex items-center gap-2">

        {{-- ── Dark / Light toggle ───────────────────────────────── --}}
        <button id="theme-toggle"
                onclick="toggleTheme()"
                title="Toggle dark / light mode"
                class="relative flex items-center gap-2 px-3 py-1.5 rounded-lg border
                       bg-gray-50 dark:bg-gray-800
                       border-gray-200 dark:border-gray-700
                       text-gray-600 dark:text-gray-300
                       hover:bg-gray-100 dark:hover:bg-gray-700
                       transition-all duration-200 text-xs font-medium select-none">

            {{-- Sun icon (shown in dark mode → click to go light) --}}
            <svg id="icon-sun" class="w-4 h-4 text-amber-500 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="4"/>
                <path stroke-linecap="round" d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
            </svg>

            {{-- Moon icon (shown in light mode → click to go dark) --}}
            <svg id="icon-moon" class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
            </svg>

            <span id="theme-label" class="hidden sm:inline">Dark mode</span>
        </button>

        {{-- Notifications --}}
        <a href="{{ route('notifications.index') }}"
           class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors relative">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </a>

        {{-- User menu --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <img src="{{ auth()->user()->avatar_url }}"
                     class="w-7 h-7 rounded-full object-cover ring-2 ring-indigo-100 dark:ring-indigo-900"
                     alt="Avatar">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200 hidden sm:block">
                    {{ auth()->user()->name }}
                </span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open"
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-1 w-52 bg-white dark:bg-gray-900
                        rounded-xl shadow-lg border border-gray-200 dark:border-gray-700
                        py-1 z-50 origin-top-right">

                {{-- User info --}}
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                    <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                </div>

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My Profile
                </a>

                <a href="{{ route('settings.general') }}"
                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>

                <div class="border-t border-gray-100 dark:border-gray-800 my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
(function () {
    // On load: sync icons + label with current state
    const dark  = document.documentElement.classList.contains('dark');
    const sun   = document.getElementById('icon-sun');
    const moon  = document.getElementById('icon-moon');
    const label = document.getElementById('theme-label');
    if (dark) {
        sun.classList.remove('hidden');
        moon.classList.add('hidden');
        if (label) label.textContent = 'Light mode';
    } else {
        sun.classList.add('hidden');
        moon.classList.remove('hidden');
        if (label) label.textContent = 'Dark mode';
    }
})();

function toggleTheme() {
    const html  = document.documentElement;
    const isDark = html.classList.toggle('dark');

    // Persist in localStorage (instant on next load)
    try { localStorage.setItem('theme', isDark ? 'dark' : 'light'); } catch(e){}

    // Sync icons + label
    const sun   = document.getElementById('icon-sun');
    const moon  = document.getElementById('icon-moon');
    const label = document.getElementById('theme-label');
    sun.classList.toggle('hidden', !isDark);
    moon.classList.toggle('hidden', isDark);
    if (label) label.textContent = isDark ? 'Light mode' : 'Dark mode';

    // Save to server (persists across devices / sessions)
    fetch('{{ route('theme.save') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: 'theme=' + (isDark ? 'dark' : 'light')
    });
}
</script>
@endpush
