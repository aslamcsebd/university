<x-app-layout>
    <x-slot name="title">Set Salary — {{ $staff->full_name }}</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('salary.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <div><h1 class="text-2xl font-bold text-gray-900">Salary Structure</h1><p class="text-sm text-gray-500">{{ $staff->full_name }} — {{ $staff->employee_id }}</p></div>
    </div>
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('salary.update', $staff) }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Basic Salary <span class="text-red-500">*</span></label><input type="number" name="basic_salary" value="{{ old('basic_salary', $salary->basic_salary ?? 0) }}" required min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('basic_salary')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">House Allowance</label><input type="number" name="house_allowance" value="{{ old('house_allowance', $salary->house_allowance ?? 0) }}" min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Transport Allowance</label><input type="number" name="transport_allowance" value="{{ old('transport_allowance', $salary->transport_allowance ?? 0) }}" min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Medical Allowance</label><input type="number" name="medical_allowance" value="{{ old('medical_allowance', $salary->medical_allowance ?? 0) }}" min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Provident Fund %</label><input type="number" name="provident_fund_pct" value="{{ old('provident_fund_pct', $salary->provident_fund_pct ?? 0) }}" min="0" max="100" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Loan Deduction</label><input type="number" name="loan_deduction" value="{{ old('loan_deduction', $salary->loan_deduction ?? 0) }}" min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Effective From <span class="text-red-500">*</span></label><input type="date" name="effective_from" value="{{ old('effective_from', $salary->effective_from?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Save Salary Structure</button>
                <a href="{{ route('salary.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
