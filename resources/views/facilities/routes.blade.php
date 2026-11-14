<x-app-layout>
    <x-slot name="title">Transport Routes</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Transport Routes</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $routes->count() }} routes</p>
        </div>
        <button onclick="document.getElementById('add-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Route
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="space-y-4">
        @forelse($routes as $route)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $route->name }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $route->from_location }} → {{ $route->to_location }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold text-green-600">৳{{ number_format($route->fare, 2) }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $route->is_active ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        {{ $route->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                <span>🚌 {{ $route->vehicle->plate_no }} ({{ ucfirst($route->vehicle->type) }}, {{ $route->vehicle->capacity }} seats)</span>
                <span>👥 {{ $route->allocations_count }} allocated</span>
                <span>🛑 {{ $route->stops->count() }} stops</span>
            </div>
            @if($route->stops->count())
            <div class="flex flex-wrap gap-2 mb-3">
                @foreach($route->stops as $stop)
                <div class="flex items-center gap-1">
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs">{{ $stop->name }}{{ $stop->pickup_time ? ' (' . $stop->pickup_time . ')' : '' }}</span>
                    <form method="POST" action="{{ route('transport-routes.stops.destroy', [$route, $stop]) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 text-xs">×</button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif
            <div class="flex items-center gap-2">
                <form method="POST" action="{{ route('transport-routes.stops.store', $route) }}" class="flex gap-2 flex-1">
                    @csrf
                    <input type="text" name="name" placeholder="Stop name" required class="flex-1 border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <input type="number" name="order" placeholder="Order" min="1" value="{{ $route->stops->count() + 1 }}" required class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <input type="time" name="pickup_time" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <button type="submit" class="px-3 py-1 bg-gray-700 text-white rounded-lg text-xs hover:bg-gray-800">+ Stop</button>
                </form>
                <form method="POST" action="{{ route('transport-routes.destroy', $route) }}" onsubmit="return confirm('Delete route?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-1 border border-red-200 text-red-500 rounded-lg text-xs hover:bg-red-50">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-400">No routes yet.</div>
        @endforelse
    </div>

    <div id="add-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="font-bold text-gray-900 mb-4">Add Route</h3>
            <form method="POST" action="{{ route('transport-routes.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Route Name *</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Vehicle *</label>
                    <select name="vehicle_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select vehicle</option>
                        @foreach($vehicles as $v)
                            <option value="{{ $v->id }}">{{ $v->plate_no }} ({{ ucfirst($v->type) }}, {{ $v->capacity }} seats)</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">From *</label>
                        <input type="text" name="from_location" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">To *</label>
                        <input type="text" name="to_location" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Fare (৳) *</label>
                    <input type="number" name="fare" min="0" step="0.01" value="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Route</button>
                    <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
