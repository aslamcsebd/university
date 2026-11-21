<x-app-layout>
    <x-slot name="title">Assign Fee</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('fee-assignments.index')
        <a href="{{ route('fee-assignments.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <h1 class="text-2xl font-bold text-gray-900">Assign Fee</h1>
    </div>
    <div class="max-w-3xl space-y-5">
        {{-- Single Assignment --}}
        @access('fee-assignments.store')
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Single Student</h3>
            <form method="POST" action="{{ route('fee-assignments.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Student <span class="text-red-500">*</span></label>
                    <select name="student_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Student —</option>
                        @foreach($students as $s)<option value="{{ $s->id }}">{{ $s->full_name }} ({{ $s->student_id }})</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Fee Type <span class="text-red-500">*</span></label>
                    <select name="fee_type_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Type —</option>
                        @foreach($feeTypes as $ft)<option value="{{ $ft->id }}">{{ $ft->name }}</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Amount <span class="text-red-500">*</span></label><input type="number" name="amount" required min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label><input type="date" name="due_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <select name="semester_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Optional —</option>
                        @foreach($semesters as $s)<option value="{{ $s->id }}" {{ $s->is_current?'selected':'' }}>{{ $s->name }}</option>@endforeach
                    </select>
                </div>
                <div class="sm:col-span-2 flex justify-end"><button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Assign Fee</button></div>
            </form>
        </div>
        @endaccess
        {{-- Bulk Assignment --}}
        @access('fee-assignments.bulk')
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Bulk — Assign to Entire Batch</h3>
            <form method="POST" action="{{ route('fee-assignments.bulk') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Batch <span class="text-red-500">*</span></label>
                    <select name="batch_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Batch —</option>
                        @foreach(\App\Models\Batch::with('program')->where('is_active',true)->get() as $b)<option value="{{ $b->id }}">{{ $b->name }} ({{ $b->program?->name }})</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Fee Type <span class="text-red-500">*</span></label>
                    <select name="fee_type_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Type —</option>
                        @foreach($feeTypes as $ft)<option value="{{ $ft->id }}">{{ $ft->name }}</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Amount <span class="text-red-500">*</span></label><input type="number" name="amount" required min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label><input type="date" name="due_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div class="sm:col-span-2 flex justify-end"><button type="submit" onclick="return confirm('Assign fee to all active students in this batch?')" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Bulk Assign</button></div>
            </form>
        </div>
        @endaccess
    </div>
</x-app-layout>
