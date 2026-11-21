<x-app-layout>
    <x-slot name="title">Library Report</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('reports.index')
        <a href="{{ route('reports.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <h1 class="text-2xl font-bold text-gray-900">Library Report</h1>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5 text-center text-gray-500">
        <p class="text-sm">Report data loaded. {{ isset($students) ? count($students) : (isset($payments) ? count($payments) : (isset($payrolls) ? count($payrolls) : (isset($incomes) ? count($incomes) : (isset($issues) ? count($issues) : 0)))) }} records found.</p>
    </div>
</x-app-layout>
