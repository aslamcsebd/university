<x-app-layout>
    <x-slot name="title">Finance Overview</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Income & Expense Overview</h1><p class="text-sm text-gray-500 mt-1">This month's summary</p></div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
        <div class="bg-green-50 border border-green-200 rounded-xl p-5"><p class="text-sm text-green-600 font-medium">Total Income (This Month)</p><p class="text-3xl font-bold text-green-800 mt-1">{{ number_format($totalIncome,2) }}</p></div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-5"><p class="text-sm text-red-600 font-medium">Total Expense (This Month)</p><p class="text-3xl font-bold text-red-800 mt-1">{{ number_format($totalExpense,2) }}</p></div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5"><p class="text-sm text-blue-600 font-medium">Net Balance</p><p class="text-3xl font-bold text-blue-800 mt-1">{{ number_format($totalIncome - $totalExpense,2) }}</p></div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between"><h2 class="font-semibold text-gray-900">Recent Incomes</h2>@access('finance.incomes.index')
<a href="{{ route('finance.incomes.index') }}" class="text-xs text-blue-600 hover:underline">View all →</a>
@endaccess</div>
            <table class="w-full text-sm"><thead class="bg-gray-50"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Title</th><th class="text-left px-5 py-2 font-medium text-gray-600">Category</th><th class="text-right px-5 py-2 font-medium text-gray-600">Amount</th></tr></thead>
            <tbody class="divide-y divide-gray-100">@forelse($recentIncomes as $i)<tr><td class="px-5 py-2 text-gray-700">{{ $i->title }}</td><td class="px-5 py-2 text-gray-500">{{ $i->category?->name }}</td><td class="px-5 py-2 text-right font-medium text-green-700">{{ number_format($i->amount,2) }}</td></tr>@empty<tr><td colspan="3" class="px-5 py-6 text-center text-gray-400">No incomes.</td></tr>@endforelse</tbody></table>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between"><h2 class="font-semibold text-gray-900">Recent Expenses</h2>@access('finance.expenses.index')
<a href="{{ route('finance.expenses.index') }}" class="text-xs text-blue-600 hover:underline">View all →</a>
@endaccess</div>
            <table class="w-full text-sm"><thead class="bg-gray-50"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Title</th><th class="text-left px-5 py-2 font-medium text-gray-600">Category</th><th class="text-right px-5 py-2 font-medium text-gray-600">Amount</th></tr></thead>
            <tbody class="divide-y divide-gray-100">@forelse($recentExpenses as $e)<tr><td class="px-5 py-2 text-gray-700">{{ $e->title }}</td><td class="px-5 py-2 text-gray-500">{{ $e->category?->name }}</td><td class="px-5 py-2 text-right font-medium text-red-700">{{ number_format($e->amount,2) }}</td></tr>@empty<tr><td colspan="3" class="px-5 py-6 text-center text-gray-400">No expenses.</td></tr>@endforelse</tbody></table>
        </div>
    </div>
</x-app-layout>
