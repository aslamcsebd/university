<x-app-layout>
    <x-slot name="title">Hostel Management</x-slot>
    <div class="mb-6 flex items-center justify-between">
        <div><h1 class="text-2xl font-bold text-gray-900">Hostel Management</h1></div>
        <div class="flex gap-2">
            <a href="{{ route('hostel.allocations') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Allocations</a>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5">
            @forelse($hostels as $hostel)
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $hostel->name }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ ucfirst($hostel->type) }} · {{ $hostel->campus?->name ?? 'No campus' }}</p>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-xs {{ $hostel->type=='male'?'bg-blue-100 text-blue-700':($hostel->type=='female'?'bg-pink-100 text-pink-700':'bg-green-100 text-green-700') }}">{{ ucfirst($hostel->type) }}</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 mt-3">{{ $hostel->rooms_count }}</p>
                <p class="text-xs text-gray-500">Rooms</p>
                <a href="{{ route('hostel.rooms', $hostel) }}" class="mt-3 block text-xs text-blue-600 hover:underline">Manage Rooms →</a>
            </div>
            @empty
            <div class="col-span-2 bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-400">No hostels yet.</div>
            @endforelse
        </div>
        <div class="space-y-5">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Add Hostel</h3>
                <form method="POST" action="{{ route('hostel.store') }}" class="space-y-3">
                    @csrf
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Name *</label><input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Type *</label>
                        <select name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="mixed">Mixed</option>
                        </select>
                    </div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Campus</label>
                        <select name="campus_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— Optional —</option>
                            @foreach($campuses as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Hostel</button>
                </form>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Room Types</h3>
                <form method="POST" action="{{ route('hostel.room-types.store') }}" class="flex gap-2 mb-3">
                    @csrf
                    <input type="text" name="name" required placeholder="e.g. Single, Double" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="number" name="capacity" required min="1" placeholder="Cap" class="w-16 border border-gray-300 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Add</button>
                </form>
                @foreach($roomTypes as $rt)<p class="text-xs text-gray-600 py-1 border-b border-gray-100">{{ $rt->name }} (Cap: {{ $rt->capacity }})</p>@endforeach
            </div>
        </div>
    </div>
</x-app-layout>
