<x-app-layout>
    <x-slot name="title">Coming Soon</x-slot>

    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Coming Soon</h1>
        <p class="text-gray-500 mb-1">This module is under development.</p>
        <p class="text-sm text-blue-600 font-medium mb-6">{{ $module }}</p>
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
            ← Back to Dashboard
        </a>
    </div>
</x-app-layout>
