<x-app-layout>
    <x-slot name="title">Enrollments</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Student Enrollments</h1><p class="text-sm text-gray-500 mt-1">Manage semester enrollments</p></div>
        <div class="flex gap-2">
            @access('enrollments.bulk')
            <a href="{{ route('enrollments.bulk') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Bulk Enroll</a>
            @endaccess
            @access('enrollments.create')
            <a href="{{ route('enrollments.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Enroll Student
            </a>
            @endaccess
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="semester" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Semesters</option>
                @foreach($semesters as $s)<option value="{{ $s->id }}" {{ request('semester')==$s->id?'selected':'' }}>{{ $s->name }} ({{ $s->academicSession?->name }})</option>@endforeach
            </select>
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                <option value="withdrawn" {{ request('status')=='withdrawn'?'selected':'' }}>Withdrawn</option>
                <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
        </form>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Student</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Program</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Semester</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Section</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Enrolled</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($enrollments as $enroll)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-900">{{ $enroll->student?->full_name }}</p>
                        <p class="text-xs font-mono text-purple-600">{{ $enroll->student?->student_id }}</p>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $enroll->student?->program?->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $enroll->semester?->name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $enroll->section?->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $enroll->enrolled_at?->format('d M Y') }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $enroll->status === 'active' ? 'bg-green-100 text-green-700' : ($enroll->status === 'withdrawn' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">{{ ucfirst($enroll->status) }}</span></td>
                    <td class="px-5 py-3 text-right">
                        @if($enroll->status === 'active')
                        @access('enrollments.withdraw')
                        <form method="POST" action="{{ route('enrollments.withdraw', $enroll) }}" onsubmit="return confirm('Withdraw this enrollment?')">@csrf @method('PATCH')
                            <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs hover:bg-red-200">Withdraw</button>
                        </form>
                        @endaccess
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-12 text-center text-gray-400">No enrollments found.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($enrollments->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $enrollments->links() }}</div>@endif
    </div>
</x-app-layout>
