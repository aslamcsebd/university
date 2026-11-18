<x-app-layout>
    <x-slot name="title">Audit Log Details</x-slot>

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('audit.index') }}" class="text-gray-400 hover:text-gray-600" aria-label="Back to audit logs">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Audit Log Details</h1>
            <p class="text-sm text-gray-500 mt-1">Activity #{{ $activity->id }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">
            <div>
                <dt class="text-gray-500">Event</dt>
                <dd class="font-medium text-gray-900 mt-1">{{ $activity->event ?? 'log' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Performed by</dt>
                <dd class="font-medium text-gray-900 mt-1">{{ $activity->causer?->name ?? 'System' }}</dd>
            </div>
            <div class="md:col-span-2">
                <dt class="text-gray-500">Description</dt>
                <dd class="font-medium text-gray-900 mt-1">{{ $activity->description }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Subject</dt>
                <dd class="font-medium text-gray-900 mt-1">
                    {{ $activity->subject_type ? class_basename($activity->subject_type).' #'.$activity->subject_id : '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-gray-500">Time</dt>
                <dd class="font-medium text-gray-900 mt-1">{{ $activity->created_at?->format('d M Y H:i:s') ?? '—' }}</dd>
            </div>
            <div class="md:col-span-2">
                <dt class="text-gray-500">Changes</dt>
                <dd class="mt-2 rounded-lg bg-gray-50 p-4 overflow-x-auto">
                    <pre class="text-xs text-gray-700 whitespace-pre-wrap">{{ json_encode($activity->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </dd>
            </div>
        </dl>
    </div>
</x-app-layout>
