<x-app-layout>
    <x-slot name="title">Suppliers</x-slot>
    <div class="mb-6 flex items-center gap-3">
        @access('inventory.index')
        <a href="{{ route('inventory.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <h1 class="text-2xl font-bold text-gray-900">Suppliers</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Name</th><th class="text-left px-5 py-3 font-medium text-gray-600">Contact</th><th class="text-left px-5 py-3 font-medium text-gray-600">Phone</th><th class="text-left px-5 py-3 font-medium text-gray-600">Stocks</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($suppliers as $s)
                    <tr class="hover:bg-gray-50"><td class="px-5 py-3 font-medium text-gray-900">{{ $s->name }}</td><td class="px-5 py-3 text-gray-500">{{ $s->contact_person ?? '—' }}</td><td class="px-5 py-3 text-gray-500">{{ $s->phone ?? '—' }}</td><td class="px-5 py-3 text-gray-500">{{ $s->stocks_count }}</td></tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-gray-400">No suppliers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($suppliers->hasPages())<div class="px-5 py-4 border-t">{{ $suppliers->links() }}</div>@endif
        </div>
        @access('inventory.suppliers.store')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Add Supplier</h3>
            <form method="POST" action="{{ route('inventory.suppliers.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Company Name *</label><input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label><input type="text" name="contact_person" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label><input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                </div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Supplier</button>
            </form>
        </div>
        @endaccess
    </div>
</x-app-layout>
