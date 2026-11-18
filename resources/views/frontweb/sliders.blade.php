<x-app-layout>
    <x-slot name="title">Sliders</x-slot>
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('frontweb.pages.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <h1 class="text-2xl font-bold text-gray-900">Homepage Sliders</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-3">
            @forelse($sliders as $slider)
            <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
                @if($slider->image)<img src="{{ asset('storage/'.$slider->image) }}" class="w-24 h-16 object-cover rounded-lg" alt="">@else<div class="w-24 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">No image</div>@endif
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900">{{ $slider->title ?? 'Untitled' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $slider->subtitle }}</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="px-2 py-0.5 rounded-full text-xs {{ $slider->is_active?'bg-green-100 text-green-700':'bg-gray-100 text-gray-500' }}">{{ $slider->is_active?'Active':'Inactive' }}</span>
                    <form method="POST" action="{{ route('frontweb.sliders.destroy', $slider) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                        <button type="submit" class="p-1 text-gray-400 hover:text-red-600 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-400">No sliders yet.</div>
            @endforelse
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Add Slider</h3>
            <form method="POST" action="{{ route('frontweb.sliders.store') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Image</label><input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-blue-50 file:text-blue-700"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Title</label><input type="text" name="title" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Subtitle</label><input type="text" name="subtitle" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Button Text</label><input type="text" name="cta_text" placeholder="Learn More" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Button Link</label><input type="text" name="cta_link" placeholder="/apply" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                </div>
                <div class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Active</label></div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Slider</button>
            </form>
        </div>
    </div>
</x-app-layout>
