<x-app-layout>
    <x-slot name="title">Salary Structures</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Salary Structures</h1><p class="text-sm text-gray-500 mt-1">Configure salary for each staff member</p></div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search staff..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Search</button>
        </form>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Staff</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Department</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Designation</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Basic Salary</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Gross</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Effective From</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($staff as $member)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-900">{{ $member->full_name }}</p>
                        <p class="text-xs text-gray-400">{{ $member->employee_id }}</p>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $member->department?->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $member->designation?->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $member->salaryStructure ? number_format($member->salaryStructure->basic_salary, 2) : '—' }}</td>
                    <td class="px-5 py-3 font-medium text-gray-900">{{ $member->salaryStructure ? number_format($member->salaryStructure->grossSalary(), 2) : '—' }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $member->salaryStructure?->effective_from?->format('d M Y') ?? '—' }}</td>
                    <td class="px-5 py-3 text-right">
                        @access('salary.edit')
                        <a href="{{ route('salary.edit', $member) }}" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700">{{ $member->salaryStructure ? 'Edit' : 'Set Salary' }}</a>
                        @endaccess
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-12 text-center text-gray-400">No staff found.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($staff->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $staff->links() }}</div>@endif
    </div>
</x-app-layout>
