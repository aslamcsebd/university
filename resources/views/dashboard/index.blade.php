<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Welcome back, {{ auth()->user()->name }}</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        @if($visibleCards['students'])
        <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['students'] ?? 0 }}</p>
                <p class="text-sm text-gray-500">Total Students</p>
            </div>
        </div>
        @endif

        @if($visibleCards['staff'])
        <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['staff'] ?? 0 }}</p>
                <p class="text-sm text-gray-500">Total Staff</p>
            </div>
        </div>
        @endif

        @if($visibleCards['admissions'])
        <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['admissions'] ?? 0 }}</p>
                <p class="text-sm text-gray-500">Pending Admissions</p>
            </div>
        </div>
        @endif

        @if($visibleCards['payments'])
        <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['payments'] ?? 0 }}</p>
                <p class="text-sm text-gray-500">Payments Today</p>
            </div>
        </div>
        @endif
    </div>

    {{-- Quick Links Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        @if($visibleCards['recent-users'])
        {{-- Recent Users --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">Recent Users</h2>
                @access('users.index')
                <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
                @endaccess
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentUsers ?? [] as $user)
                    <div class="flex items-center gap-3 px-5 py-3">
                        <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full object-cover" alt="">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-sm text-gray-400">No users yet</div>
                @endforelse
            </div>
        </div>

        @endif
        {{-- System Info --}}
        @if($visibleCards['system-info'])
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">System Info</h2>
                @access('settings.general')
<a href="{{ route('settings.general') }}" class="text-sm text-blue-600 hover:underline">Settings</a>
@endaccess

            </div>
            <div class="px-5 py-4 space-y-3">
                @php $uni = $university; @endphp
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">University</span>
                    <span class="font-medium text-gray-900">{{ $uni?->name ?? 'Not configured' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Timezone</span>
                    <span class="font-medium text-gray-900">{{ $uni?->timezone ?? 'UTC' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Currency</span>
                    <span class="font-medium text-gray-900">{{ $uni?->currency ?? 'USD' }} ({{ $uni?->currency_symbol ?? '$' }})</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Laravel</span>
                    <span class="font-medium text-gray-900">{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">PHP</span>
                    <span class="font-medium text-gray-900">{{ PHP_VERSION }}</span>
                </div>
                @can('view.users')
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Users</span>
                    <span class="font-medium text-gray-900">{{ $userCount }}</span>
                </div>
                @endcan
                @can('view.roles')
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Roles</span>
                    <span class="font-medium text-gray-900">{{ $roleCount }}</span>
                </div>
                @endcan
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
