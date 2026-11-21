<x-app-layout>
    <x-slot name="title">Transport Management</x-slot>
    <div class="mb-6 flex items-center justify-between">
        <div><h1 class="text-2xl font-bold text-gray-900">Transport Management</h1></div>
        @access('transport.allocations')
        <a href="{{ route('transport.allocations') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Allocations</a>
        @endaccess
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Vehicles --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Vehicles</h2></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Plate No</th><th class="text-left px-5 py-2 font-medium text-gray-600">Type</th><th class="text-left px-5 py-2 font-medium text-gray-600">Capacity</th><th class="text-left px-5 py-2 font-medium text-gray-600">Routes</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($vehicles as $v)
                    <tr><td class="px-5 py-2 font-mono font-medium text-gray-900">{{ $v->plate_no }}</td><td class="px-5 py-2 text-gray-500">{{ ucfirst($v->type) }}</td><td class="px-5 py-2 text-gray-700">{{ $v->capacity }}</td><td class="px-5 py-2 text-gray-500">{{ $v->routes_count }}</td></tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">No vehicles.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-gray-100 p-4">
                @access('transport.vehicles.store')
                <form method="POST" action="{{ route('transport.vehicles.store') }}" class="grid grid-cols-2 gap-2">
                    @csrf
                    <input type="text" name="plate_no" required placeholder="Plate No" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select name="type" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="bus">Bus</option><option value="van">Van</option><option value="car">Car</option></select>
                    <input type="number" name="capacity" required min="1" placeholder="Capacity" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Vehicle</button>
                </form>
                @endaccess
            </div>
        </div>
        {{-- Routes --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Routes</h2></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Route</th><th class="text-left px-5 py-2 font-medium text-gray-600">Vehicle</th><th class="text-left px-5 py-2 font-medium text-gray-600">Fare</th><th class="text-left px-5 py-2 font-medium text-gray-600">Allocations</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($routes as $r)
                    <tr><td class="px-5 py-2 font-medium text-gray-900">{{ $r->name }}</td><td class="px-5 py-2 text-gray-500">{{ $r->vehicle?->plate_no }}</td><td class="px-5 py-2 text-gray-700">{{ number_format($r->fare,2) }}</td><td class="px-5 py-2 text-gray-500">{{ $r->allocations_count }}</td></tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">No routes.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-gray-100 p-4">
                @access('transport.routes.store')
                <form method="POST" action="{{ route('transport.routes.store') }}" class="grid grid-cols-2 gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Route name" class="col-span-2 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select name="vehicle_id" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Vehicle —</option>
                        @foreach($vehicles as $v)<option value="{{ $v->id }}">{{ $v->plate_no }}</option>@endforeach
                    </select>
                    <input type="number" name="fare" placeholder="Fare" min="0" step="0.01" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="col-span-2 bg-blue-600 text-white rounded-lg text-sm font-medium py-2 hover:bg-blue-700">Add Route</button>
                </form>
                @endaccess
            </div>
        </div>
    </div>
</x-app-layout>
