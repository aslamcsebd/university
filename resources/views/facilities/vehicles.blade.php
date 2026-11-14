<x-app-layout>
    <x-slot name="title">Vehicles</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Vehicles</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $vehicles->count() }} vehicles</p>
        </div>
        <button onclick="document.getElementById('add-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Vehicle
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Plate No</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Type</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Model / Year</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Capacity</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Driver</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($vehicles as $vehicle)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-bold font-mono text-gray-900">{{ $vehicle->plate_no }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full text-xs font-medium capitalize">{{ $vehicle->type }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $vehicle->model ?? '—' }} {{ $vehicle->year ? '(' . $vehicle->year . ')' : '' }}</td>
                    <td class="px-4 py-3 text-center font-bold text-gray-700">{{ $vehicle->capacity }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $vehicle->driver ? $vehicle->driver->first_name . ' ' . $vehicle->driver->last_name : '—' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $vehicle->is_active ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            {{ $vehicle->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end gap-2">
                            <button onclick='openEditVehicle({{ json_encode($vehicle) }})'
                                    class="text-xs text-blue-600 hover:underline font-medium">Edit</button>
                            <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}" onsubmit="return confirm('Delete vehicle?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:underline font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">No vehicles yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="add-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="font-bold text-gray-900 mb-4">Add Vehicle</h3>
            <form method="POST" action="{{ route('vehicles.store') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Plate No *</label>
                        <input type="text" name="plate_no" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Type *</label>
                        <select name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="bus">Bus</option>
                            <option value="van">Van</option>
                            <option value="car">Car</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Capacity *</label>
                        <input type="number" name="capacity" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Model</label>
                        <input type="text" name="model" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Year</label>
                        <input type="number" name="year" min="1990" max="{{ date('Y') + 1 }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Driver</label>
                        <select name="driver_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">None</option>
                            @foreach($drivers as $d)
                                <option value="{{ $d->id }}">{{ $d->first_name }} {{ $d->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Vehicle</button>
                    <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="edit-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="font-bold text-gray-900 mb-4">Edit Vehicle</h3>
            <form method="POST" id="edit-form" class="space-y-3">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Plate No *</label>
                        <input type="text" name="plate_no" id="edit-plate" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Type *</label>
                        <select name="type" id="edit-type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="bus">Bus</option>
                            <option value="van">Van</option>
                            <option value="car">Car</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Capacity *</label>
                        <input type="number" name="capacity" id="edit-capacity" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Model</label>
                        <input type="text" name="model" id="edit-model" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update</button>
                    <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEditVehicle(v) {
            document.getElementById('edit-form').action = '/vehicles/' + v.id;
            document.getElementById('edit-plate').value = v.plate_no;
            document.getElementById('edit-type').value = v.type;
            document.getElementById('edit-capacity').value = v.capacity;
            document.getElementById('edit-model').value = v.model || '';
            document.getElementById('edit-modal').classList.remove('hidden');
        }
    </script>
    @endpush
</x-app-layout>
