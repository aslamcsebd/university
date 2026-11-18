<x-app-layout>
    <x-slot name="title">Reports & Analytics</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Reports & Analytics</h1><p class="text-sm text-gray-500 mt-1">System-wide reports and statistics</p></div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><p class="text-2xl font-bold text-blue-600">{{ $stats['total_students'] }}</p><p class="text-xs text-gray-500 mt-1">Active Students</p></div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><p class="text-2xl font-bold text-green-600">{{ $stats['total_staff'] }}</p><p class="text-xs text-gray-500 mt-1">Active Staff</p></div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><p class="text-2xl font-bold text-purple-600">{{ number_format($stats['fees_this_month']) }}</p><p class="text-xs text-gray-500 mt-1">Fees This Month</p></div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><p class="text-2xl font-bold text-red-600">{{ number_format($stats['expenses_month']) }}</p><p class="text-xs text-gray-500 mt-1">Expenses This Month</p></div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><p class="text-2xl font-bold text-orange-600">{{ $stats['overdue_books'] }}</p><p class="text-xs text-gray-500 mt-1">Overdue Books</p></div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_leaves'] }}</p><p class="text-xs text-gray-500 mt-1">Pending Leaves</p></div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('reports.students') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-sm transition-shadow flex items-center gap-4"><span class="px-3 py-1.5 rounded-lg text-sm font-medium bg-blue-100 text-blue-700">View →</span><span class="font-medium text-gray-900">Students Report</span></a>
        <a href="{{ route('reports.fees') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-sm transition-shadow flex items-center gap-4"><span class="px-3 py-1.5 rounded-lg text-sm font-medium bg-green-100 text-green-700">View →</span><span class="font-medium text-gray-900">Fees Collected</span></a>
        <a href="{{ route('reports.salary') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-sm transition-shadow flex items-center gap-4"><span class="px-3 py-1.5 rounded-lg text-sm font-medium bg-purple-100 text-purple-700">View →</span><span class="font-medium text-gray-900">Salary Report</span></a>
        <a href="{{ route('reports.finance') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-sm transition-shadow flex items-center gap-4"><span class="px-3 py-1.5 rounded-lg text-sm font-medium bg-yellow-100 text-yellow-700">View →</span><span class="font-medium text-gray-900">Finance Overview</span></a>
        <a href="{{ route('reports.library') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-sm transition-shadow flex items-center gap-4"><span class="px-3 py-1.5 rounded-lg text-sm font-medium bg-indigo-100 text-indigo-700">View →</span><span class="font-medium text-gray-900">Library History</span></a>
    </div>
</x-app-layout>
