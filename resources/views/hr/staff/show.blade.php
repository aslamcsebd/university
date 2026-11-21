<x-app-layout>
    <x-slot name="title">{{ $staff->full_name }}</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('staff.index')
        <a href="{{ route('staff.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <h1 class="text-2xl font-bold text-gray-900">Staff Profile</h1>
        @access('staff.edit')
        <a href="{{ route('staff.edit', $staff) }}" class="ml-auto px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Edit</a>
        @endaccess
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
        {{-- Profile Card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 text-center">
            <img src="{{ $staff->photo_url }}" class="w-20 h-20 rounded-full mx-auto mb-3 object-cover">
            <h2 class="font-semibold text-gray-900">{{ $staff->full_name }}</h2>
            <p class="text-xs text-gray-500 mt-0.5">{{ $staff->designation?->name }}</p>
            <p class="text-xs font-mono text-blue-600 mt-1">{{ $staff->employee_id }}</p>
            <span class="mt-2 inline-block px-2 py-0.5 rounded-full text-xs {{ $staff->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $staff->is_active ? 'Active' : 'Inactive' }}</span>
        </div>
        {{-- Details --}}
        <div class="lg:col-span-3 space-y-5">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Employment Details</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div><p class="text-gray-500">Department</p><p class="font-medium">{{ $staff->department?->name ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Designation</p><p class="font-medium">{{ $staff->designation?->name ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Work Shift</p><p class="font-medium">{{ $staff->workShift?->name ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Employment Type</p><p class="font-medium">{{ ucfirst(str_replace('_',' ',$staff->employment_type)) }}</p></div>
                    <div><p class="text-gray-500">Join Date</p><p class="font-medium">{{ $staff->join_date?->format('d M Y') ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Experience</p><p class="font-medium">{{ $staff->experience_years }} years</p></div>
                    <div><p class="text-gray-500">Qualification</p><p class="font-medium">{{ $staff->highest_degree ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Phone</p><p class="font-medium">{{ $staff->phone ?? '—' }}</p></div>
                    <div><p class="text-gray-500">Email</p><p class="font-medium">{{ $staff->personal_email ?? '—' }}</p></div>
                </div>
            </div>
            {{-- Recent Payrolls --}}
            @if($payrolls->count())
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Recent Payrolls</h3>
                    @access('payroll.index')
                    <a href="{{ route('payroll.index') }}" class="text-xs text-blue-600 hover:underline">View all →</a>
                    @endaccess
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Month</th><th class="text-left px-5 py-2 font-medium text-gray-600">Gross</th><th class="text-left px-5 py-2 font-medium text-gray-600">Net</th><th class="text-left px-5 py-2 font-medium text-gray-600">Status</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($payrolls as $p)
                        <tr><td class="px-5 py-2 text-gray-700">{{ $p->month_name }} {{ $p->year }}</td><td class="px-5 py-2 text-gray-700">{{ number_format($p->gross, 2) }}</td><td class="px-5 py-2 font-medium text-gray-900">{{ number_format($p->net_salary, 2) }}</td><td class="px-5 py-2"><span class="px-2 py-0.5 rounded-full text-xs {{ $p->status_color }}">{{ ucfirst($p->status) }}</span></td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
