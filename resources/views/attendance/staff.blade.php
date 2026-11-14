<x-app-layout>
    <x-slot name="title">Staff Attendance</x-slot>
    <div class="mb-6 flex items-center justify-between">
        <div><h1 class="text-2xl font-bold text-gray-900">Staff Attendance</h1><p class="text-sm text-gray-500 mt-1">Daily attendance for {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</p></div>
        <form method="GET" class="flex gap-2">
            <input type="date" name="date" value="{{ $date }}" max="{{ now()->format('Y-m-d') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">View</button>
        </form>
    </div>
    <form method="POST" action="{{ route('attendance.staff.mark') }}" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Staff</th><th class="text-left px-5 py-3 font-medium text-gray-600">Designation</th><th class="text-left px-5 py-3 font-medium text-gray-600">Status</th><th class="text-left px-5 py-3 font-medium text-gray-600">Check In</th><th class="text-left px-5 py-3 font-medium text-gray-600">Check Out</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($staff as $member)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $member->photo_url }}" class="w-7 h-7 rounded-full object-cover" alt="">
                            <div><p class="font-medium text-gray-900">{{ $member->full_name }}</p><p class="text-xs text-gray-400">{{ $member->employee_id }}</p></div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $member->designation?->name ?? '—' }}</td>
                    <td class="px-5 py-3">
                        <select name="attendance[{{ $member->id }}][status]" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach(['present','absent','late','half_day','on_leave'] as $s)
                            <option value="{{ $s }}" {{ ($existing[$member->id] ?? 'present') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-5 py-3"><input type="time" name="attendance[{{ $member->id }}][check_in]" class="border border-gray-300 rounded px-2 py-1 text-xs"></td>
                    <td class="px-5 py-3"><input type="time" name="attendance[{{ $member->id }}][check_out]" class="border border-gray-300 rounded px-2 py-1 text-xs"></td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">No staff found.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($staff->isNotEmpty())
        <div class="px-5 py-4 border-t border-gray-100">
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Save Attendance</button>
        </div>
        @endif
    </form>
</x-app-layout>
