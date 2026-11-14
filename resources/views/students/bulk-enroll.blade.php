<x-app-layout>
    <x-slot name="title">Bulk Enrollment</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('enrollments.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <h1 class="text-2xl font-bold text-gray-900">Bulk Enrollment</h1>
    </div>
    <div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-sm text-gray-500 mb-4">Enroll all active students in a batch into a semester at once.</p>
        <form method="POST" action="{{ route('enrollments.bulk-store') }}" class="space-y-4">
            @csrf
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Batch <span class="text-red-500">*</span></label>
                <select name="batch_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Select Batch —</option>
                    @foreach($sections as $s)<option value="{{ $s->batch_id }}">{{ $s->batch?->name }}</option>@endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Semester <span class="text-red-500">*</span></label>
                <select name="semester_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Select Semester —</option>
                    @foreach($semesters as $s)<option value="{{ $s->id }}" {{ $s->is_current ? 'selected' : '' }}>{{ $s->name }} {{ $s->is_current ? '★ Current' : '' }}</option>@endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                <select name="section_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— No section —</option>
                    @foreach($sections as $s)<option value="{{ $s->id }}">{{ $s->batch?->name }} — Section {{ $s->name }}</option>@endforeach
                </select>
            </div>
            <button type="submit" onclick="return confirm('Enroll all active students in selected batch?')" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Bulk Enroll</button>
        </form>
    </div>
</x-app-layout>
