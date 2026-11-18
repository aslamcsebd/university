<x-app-layout>
    <x-slot name="title">Front Website CMS</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Front Website CMS</h1><p class="text-sm text-gray-500 mt-1">Manage the public-facing website content</p></div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ route('frontweb.sliders.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-sm transition-shadow">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3"><svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
            <h3 class="font-semibold text-gray-900">Sliders</h3>
            <p class="text-sm text-gray-500 mt-1">Homepage banner images</p>
        </a>
        <a href="{{ route('frontweb.news.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-sm transition-shadow">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3"><svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg></div>
            <h3 class="font-semibold text-gray-900">News</h3>
            <p class="text-sm text-gray-500 mt-1">News articles and announcements</p>
        </a>
        <a href="{{ route('events.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-sm transition-shadow">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-3"><svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
            <h3 class="font-semibold text-gray-900">Events</h3>
            <p class="text-sm text-gray-500 mt-1">Public events calendar</p>
        </a>
    </div>
</x-app-layout>
