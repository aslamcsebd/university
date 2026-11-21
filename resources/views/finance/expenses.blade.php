<x-app-layout>
    <x-slot name="title">Expenses</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Expense Records</h1></div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Date</th><th class="text-left px-5 py-3 font-medium text-gray-600">Title</th><th class="text-left px-5 py-3 font-medium text-gray-600">Category</th><th class="text-right px-5 py-3 font-medium text-gray-600">Amount</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($expenses as $expense)
                    <tr class="hover:bg-gray-50"><td class="px-5 py-2 text-gray-500">{{ $expense->date->format('d M Y') }}</td><td class="px-5 py-2 font-medium text-gray-900">{{ $expense->title }}</td><td class="px-5 py-2 text-gray-500">{{ $expense->category?->name }}</td><td class="px-5 py-2 text-right font-semibold text-red-700">{{ number_format($expense->amount,2) }}</td></tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-gray-400">No expense records.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($expenses->hasPages())<div class="px-5 py-4 border-t">{{ $expenses->links() }}</div>@endif
        </div>
        <div class="space-y-5">
            @access('finance.expenses.store')
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Add Expense</h3>
                <form method="POST" action="{{ route('finance.expenses.store') }}" class="space-y-3">
                    @csrf
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Category *</label>
                        <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— Select —</option>
                            @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                        </select>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Title *</label><input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Amount *</label><input type="number" name="amount" required min="0.01" step="0.01" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Date *</label><input type="date" name="date" value="{{ now()->format('Y-m-d') }}" required class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    </div>
                    <button type="submit" class="w-full py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700">Add Expense</button>
                </form>
            </div>
            @endaccess
            @access('finance.expense-categories.store')
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Add Category</h3>
                <form method="POST" action="{{ route('finance.expense-categories.store') }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Category name" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Add</button>
                </form>
            </div>
            @endaccess
        </div>
    </div>
</x-app-layout>
