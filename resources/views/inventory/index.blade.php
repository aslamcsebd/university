<x-app-layout>
    <x-slot name="title">Inventory</x-slot>
    <div class="mb-6 flex items-center justify-between">
        <div><h1 class="text-2xl font-bold text-gray-900">Inventory</h1><p class="text-sm text-gray-500 mt-1">{{ $lowStock }} item(s) low on stock</p></div>
        @access('suppliers.index')
        <a href="{{ route('suppliers.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Suppliers</a>
        @endaccess
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
                <form method="GET" class="flex gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search items..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $c)<option value="{{ $c->id }}" {{ request('category')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Filter</button>
                </form>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Item</th><th class="text-left px-5 py-3 font-medium text-gray-600">Category</th><th class="text-left px-5 py-3 font-medium text-gray-600">Store</th><th class="text-left px-5 py-3 font-medium text-gray-600">Qty</th><th class="text-left px-5 py-3 font-medium text-gray-600">Unit</th><th class="text-right px-5 py-3 font-medium text-gray-600">Stock In</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $item)
                        <tr class="hover:bg-gray-50 {{ $item->isLowStock() ? 'bg-red-50' : '' }}">
                            <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ $item->name }}</p>@if($item->isLowStock())<span class="text-xs text-red-600">⚠ Low Stock</span>@endif</td>
                            <td class="px-5 py-3 text-gray-500">{{ $item->category?->name }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $item->store?->name }}</td>
                            <td class="px-5 py-3 font-semibold {{ $item->isLowStock() ? 'text-red-600' : 'text-gray-900' }}">{{ $item->quantity }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $item->unit }}</td>
                            <td class="px-5 py-3 text-right">
                                @access('inventory.stock-in')
<button onclick="document.getElementById('stockin-{{ $item->id }}').classList.toggle('hidden')" class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs hover:bg-blue-200">Stock In</button>
@endaccess

                                @access('inventory.stock-in')
<form id="stockin-{{ $item->id }}" method="POST" action="{{ route('inventory.stock-in') }}" class="hidden mt-2 flex gap-2">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <input type="number" name="quantity" required min="0.01" step="0.01" placeholder="Qty" class="w-20 border border-gray-300 rounded px-2 py-1 text-xs">
                                    <input type="date" name="purchase_date" value="{{ now()->format('Y-m-d') }}" required class="border border-gray-300 rounded px-2 py-1 text-xs">
                                    <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded text-xs">Add</button>
                                </form>
@endaccess

                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400">No items yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($items->hasPages())<div class="px-5 py-4 border-t">{{ $items->links() }}</div>@endif
            </div>
        </div>
        <div class="space-y-5">
            @access('inventory.items.store')
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Add Item</h3>
                <form method="POST" action="{{ route('inventory.items.store') }}" class="space-y-3">
                    @csrf
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Category *</label>
                        <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— Select —</option>
                            @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                        </select>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Store *</label>
                        <select name="store_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— Select —</option>
                            @foreach($stores as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach
                        </select>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Item Name *</label><input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Unit *</label><input type="text" name="unit" required placeholder="pcs, kg, ltr" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                        <div><label class="block text-xs font-medium text-gray-700 mb-1">Min Threshold</label><input type="number" name="min_threshold" value="5" min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    </div>
                    <div class="flex items-center gap-2"><input type="checkbox" name="is_consumable" value="1" checked class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Consumable</label></div>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Item</button>
                </form>
            </div>
            @endaccess
            @access('inventory.categories.store')
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Add Category / Store</h3>
                <form method="POST" action="{{ route('inventory.categories.store') }}" class="flex gap-2 mb-2">
                    @csrf<input type="text" name="name" required placeholder="Category name" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm">+Cat</button>
                </form>
                <form method="POST" action="{{ route('inventory.stores.store') }}" class="flex gap-2">
                    @csrf<input type="text" name="name" required placeholder="Store name" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><button type="submit" class="px-3 py-2 bg-green-600 text-white rounded-lg text-sm">+Store</button>
                </form>
            </div>
            @endaccess
        </div>
    </div>
</x-app-layout>
