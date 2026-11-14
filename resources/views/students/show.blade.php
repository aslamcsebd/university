<x-app-layout>
    <x-slot name="title">{{ $student->full_name }}</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('students.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <h1 class="text-2xl font-bold text-gray-900">Student Profile</h1>
        <a href="{{ route('students.edit', $student) }}" class="ml-auto px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Edit</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
        {{-- Profile Card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 text-center">
            <img src="{{ $student->photo_url }}" class="w-20 h-20 rounded-full mx-auto mb-3 object-cover">
            <h2 class="font-semibold text-gray-900">{{ $student->full_name }}</h2>
            <p class="text-xs font-mono text-purple-600 mt-1">{{ $student->student_id }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $student->program?->name }}</p>
            <span class="mt-2 inline-block px-2 py-0.5 rounded-full text-xs {{ $student->status_color }}">{{ ucfirst($student->status) }}</span>
            <div class="mt-4 text-left space-y-2 text-xs text-gray-500 border-t border-gray-100 pt-3">
                <p><span class="font-medium">Batch:</span> {{ $student->batch?->name ?? '—' }}</p>
                <p><span class="font-medium">Admitted:</span> {{ $student->admission_date?->format('d M Y') ?? '—' }}</p>
                <p><span class="font-medium">Gender:</span> {{ ucfirst($student->gender ?? '—') }}</p>
                <p><span class="font-medium">Phone:</span> {{ $student->phone ?? '—' }}</p>
            </div>
        </div>

        {{-- Tabs Content --}}
        <div class="lg:col-span-3 space-y-5">
            {{-- Academic --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Academic Information</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div><p class="text-gray-500">Program</p><p class="font-medium">{{ $student->program?->name ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Department</p><p class="font-medium">{{ $student->program?->department?->name ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Batch</p><p class="font-medium">{{ $student->batch?->name ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Current Semester</p><p class="font-medium">{{ $student->currentSemester?->name ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Admission Date</p><p class="font-medium">{{ $student->admission_date?->format('d M Y') ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Login</p><p class="font-medium">{{ $student->user?->email ?? 'No account' }}</p></div>
                </div>
            </div>

            {{-- Guardian --}}
            @if($student->guardian_name)
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Guardian Information</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div><p class="text-gray-500">Name</p><p class="font-medium">{{ $student->guardian_name }}</p></div>
                    <div><p class="text-gray-500">Phone</p><p class="font-medium">{{ $student->guardian_phone ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Relation</p><p class="font-medium">{{ $student->guardian_relation ?? '—' }}</p></div>
                </div>
            </div>
            @endif

            {{-- Enrollments --}}
            @if($student->enrollments->count())
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100"><h3 class="font-semibold text-gray-900">Enrollment History</h3></div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Semester</th><th class="text-left px-5 py-2 font-medium text-gray-600">Section</th><th class="text-left px-5 py-2 font-medium text-gray-600">Enrolled</th><th class="text-left px-5 py-2 font-medium text-gray-600">Status</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($student->enrollments as $enroll)
                        <tr><td class="px-5 py-2 text-gray-700">{{ $enroll->semester?->name }}</td><td class="px-5 py-2 text-gray-500">{{ $enroll->section?->name ?? '—' }}</td><td class="px-5 py-2 text-gray-500">{{ $enroll->enrolled_at?->format('d M Y') }}</td><td class="px-5 py-2"><span class="px-2 py-0.5 rounded-full text-xs {{ $enroll->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($enroll->status) }}</span></td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Notes --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Notes</h3>
                @forelse($student->notes as $note)
                <div class="mb-3 pb-3 border-b border-gray-100 last:border-0">
                    <p class="text-sm text-gray-700">{{ $note->note }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $note->creator?->name }} — {{ $note->created_at->format('d M Y H:i') }}</p>
                </div>
                @empty<p class="text-sm text-gray-400">No notes.</p>@endforelse
                <form method="POST" action="{{ route('students.notes.store', $student) }}" class="mt-3 flex gap-2">
                    @csrf
                    <input type="text" name="note" placeholder="Add a note..." required class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Add</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
