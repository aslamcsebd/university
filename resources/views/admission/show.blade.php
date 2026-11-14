<x-app-layout>
    <x-slot name="title">Application — {{ $admission->applicant_name }}</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admissions.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <h1 class="text-2xl font-bold text-gray-900">Application Details</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Details --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Applicant Information</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500">Name</dt><dd class="font-medium text-gray-900">{{ $admission->applicant_name }}</dd></div>
                    <div><dt class="text-gray-500">Email</dt><dd class="font-medium text-gray-900">{{ $admission->email }}</dd></div>
                    <div><dt class="text-gray-500">Phone</dt><dd class="font-medium text-gray-900">{{ $admission->phone ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Date of Birth</dt><dd class="font-medium text-gray-900">{{ $admission->dob?->format('d M Y') ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Program</dt><dd class="font-medium text-gray-900">{{ $admission->program?->name }}</dd></div>
                    <div><dt class="text-gray-500">Session</dt><dd class="font-medium text-gray-900">{{ $admission->academicSession?->name ?? '—' }}</dd></div>
                    <div class="col-span-2"><dt class="text-gray-500">Address</dt><dd class="font-medium text-gray-900">{{ $admission->address ?? '—' }}</dd></div>
                    <div class="col-span-2"><dt class="text-gray-500">Remarks</dt><dd class="text-gray-700">{{ $admission->remarks ?? '—' }}</dd></div>
                </dl>
            </div>

            {{-- Status History --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100"><h3 class="font-semibold text-gray-900">Status History</h3></div>
                <div class="divide-y divide-gray-100">
                    @forelse($admission->statusHistory as $hist)
                    <div class="px-5 py-3 flex items-center justify-between">
                        <div>
                            @if($hist->status)<span class="px-2 py-0.5 rounded-full text-xs text-white font-medium" style="background-color: {{ $hist->status->color }}">{{ $hist->status->name }}</span>@endif
                            @if($hist->note)<p class="text-xs text-gray-500 mt-1">{{ $hist->note }}</p>@endif
                        </div>
                        <div class="text-right text-xs text-gray-400">
                            <p>{{ $hist->changedBy?->name ?? 'System' }}</p>
                            <p>{{ $hist->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-6 text-center text-gray-400 text-sm">No history.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="space-y-5">
            {{-- Current Status --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Current Status</h3>
                @if($admission->status)
                <span class="px-3 py-1 rounded-full text-sm text-white font-medium" style="background-color: {{ $admission->status->color }}">{{ $admission->status->name }}</span>
                @else<span class="text-gray-400 text-sm">Not set</span>@endif
                <p class="text-xs text-gray-400 mt-2">Applied: {{ $admission->created_at->format('d M Y') }}</p>
            </div>

            {{-- Update Status --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Update Status</h3>
                <form method="POST" action="{{ route('admissions.status', $admission) }}" class="space-y-3">
                    @csrf @method('PATCH')
                    <select name="status_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Status —</option>
                        @foreach($statuses as $st)<option value="{{ $st->id }}" {{ $admission->status_id == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>@endforeach
                    </select>
                    <textarea name="note" rows="2" placeholder="Note (optional)" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update Status</button>
                </form>
            </div>

            {{-- Convert to Student --}}
            @if($admission->status?->is_approval_trigger)
            <div class="bg-green-50 border border-green-200 rounded-xl p-5">
                <h3 class="font-semibold text-green-800 mb-2">Convert to Student</h3>
                <p class="text-xs text-green-700 mb-3">Application is approved. Convert to create a student account.</p>
                <form method="POST" action="{{ route('admissions.convert', $admission) }}" onsubmit="return confirm('Convert this application to a student?')">
                    @csrf
                    <button type="submit" class="w-full py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700">Convert to Student</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
