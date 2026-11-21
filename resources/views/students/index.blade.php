<x-app-layout>
    <x-slot name="title">Students</x-slot>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Students</h1><p class="text-sm text-gray-500 mt-1">{{ number_format($students->total()) }} students found</p></div>
        @access('students.create')
        <a href="{{ route('students.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Student
        </a>
        @endaccess
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, ID or email..." class="flex-1 min-w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="program" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Programs</option>
                @foreach($programs as $p)<option value="{{ $p->id }}" {{ request('program')==$p->id?'selected':'' }}>{{ $p->name }}</option>@endforeach
            </select>
            <select name="batch" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Batches</option>
                @foreach($batches as $b)<option value="{{ $b->id }}" {{ request('batch')==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
            </select>
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                @foreach($statuses as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
            @if(request()->hasAny(['search','program','batch','status']))@access('students.index')
<a href="{{ route('students.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Clear</a>
        @endaccess
@endif
        </form>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Student</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Student ID</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Program</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Batch</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Admission</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $student->photo_url }}" class="w-8 h-8 rounded-full object-cover" alt="">
                            <div>
                                <p class="font-medium text-gray-900">{{ $student->full_name }}</p>
                                <p class="text-xs text-gray-400">{{ $student->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 font-mono text-xs text-purple-600 font-medium">{{ $student->student_id }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $student->program?->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $student->batch?->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $student->admission_date?->format('d M Y') ?? '—' }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $student->status_color }}">{{ ucfirst($student->status) }}</span></td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            @access('students.show')
                            <a href="{{ route('students.show', $student) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                            @endaccess
                            @access('students.edit')
                            <a href="{{ route('students.edit', $student) }}" class="p-1.5 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                            @endaccess
                            @access('students.destroy')
                            <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete student?')">@csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                            @endaccess
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-12 text-center text-gray-400">No students found. @access('students.create')
<a href="{{ route('students.create') }}" class="text-blue-600">Add one →</a>
@endaccess</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($students->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $students->links() }}</div>@endif
    </div>
</x-app-layout>
